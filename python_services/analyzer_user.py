#!/usr/bin/env python3
# -*- coding: utf-8 -*-

import sys
import os
import re
import json
from datetime import datetime, timedelta
from collections import Counter
from difflib import SequenceMatcher
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics.pairwise import cosine_similarity

# =============================
# LOAD DATASET
# =============================
BASE_DIR = os.path.dirname(__file__)

with open(os.path.join(BASE_DIR, 'dataset_kasar.json'), encoding='utf-8') as f:
    kasar_list = json.load(f)

with open(os.path.join(BASE_DIR, 'dataset_spam.json'), encoding='utf-8') as f:
    spam_data = json.load(f)

spam_keywords = spam_data["keywords"]
spam_patterns = spam_data["patterns"]

# =============================
# KONFIGURASI WINDOW WAKTU
# Duplikat hanya dicek dalam rentang waktu tertentu
# sesuai panjang teks, supaya komentar lama tidak
# dianggap duplikat dari komentar baru.
# =============================
TIME_WINDOWS = {
    "short":  timedelta(hours=1),
    "medium": timedelta(hours=6),
    "long":   timedelta(days=1),
}

# History lebih dari batas ini akan dibersihkan otomatis
HISTORY_RETENTION = timedelta(days=7)

# =============================
# PREPROCESSING
# =============================
def preprocess(text):
    text = text.lower()
    text = re.sub(r'[^a-z0-9\s]', '', text)
    text = re.sub(r'(.)\1{2,}', r'\1\1', text)
    text = re.sub(r'\s+', ' ', text).strip()
    tokens = text.split()
    return tokens


def parse_timestamp(value):
    if not value:
        return None
    try:
        return datetime.fromisoformat(value)
    except ValueError:
        return None


def map_angka(tokens):
    """Normalisasi leet speak: 4→a, 1→i, 0→o, 3→e, 5→s"""
    mapping = {'1': 'i', '4': 'a', '5': 's', '0': 'o', '3': 'e'}
    new_tokens = []
    for word in tokens:
        if re.fullmatch(r'\d+', word):
            new_tokens.append(word)
        else:
            for k, v in mapping.items():
                word = word.replace(k, v)
            new_tokens.append(word)
    return new_tokens


def generate_ngrams(tokens, n=2):
    return [' '.join(tokens[i:i + n]) for i in range(len(tokens) - n + 1)]


# =============================
# KASAR DETECTION
# =============================
def check_kasar(tokens):
    """
    Fuzzy matching tiap token ke dataset kata kasar.
    Threshold 0.8 supaya variasi typo tetap tertangkap.
    """
    for word in tokens:
        for kasar in kasar_list:
            similarity = SequenceMatcher(None, word, kasar).ratio()
            if similarity >= 0.8:
                return True
    return False


# =============================
# SPAM DETECTION
# =============================
def check_spam(text):
    """
    Tiga lapis pengecekan spam:
    1. Regex pattern dari dataset
    2. Exact keyword match
    3. Keyword match di bigram
    """
    text_lower = text.lower()
    tokens = text_lower.split()
    bigrams = generate_ngrams(tokens, 2)

    for p in spam_patterns:
        if re.search(p, text_lower):
            return True

    for keyword in spam_keywords:
        if keyword in text_lower:
            return True
        if keyword in bigrams:
            return True

    return False


# =============================
# COSINE SIMILARITY (TF-IDF)
# =============================
def hitung_cosine(text1, text2):
    if not text1.strip() or not text2.strip():
        return 0.0
    try:
        vectorizer = TfidfVectorizer().fit_transform([text1, text2])
        vectors = vectorizer.toarray()
        cosine = cosine_similarity(vectors)
        return cosine[0][1]
    except Exception:
        return 0.0


# =============================
# NORMALIZE HISTORY
# =============================
def normalize_history(raw_list):
    """
    Normalisasi tiap entry history ke format standar dict
    dengan field 'text', 'created_at', dan 'user'.
    """
    result = []
    for item in raw_list:
        if isinstance(item, str):
            result.append({'text': item, 'created_at': None, 'user': None})
        elif isinstance(item, dict) and 'text' in item:
            result.append({
                'text': item.get('text', ''),
                'created_at': item.get('created_at'),
                'user': item.get('user'),
            })
    return result


# =============================
# BERSIHKAN HISTORY LAMA
# =============================
def bersihkan_history(history):
    """
    Buang entry yang lebih tua dari HISTORY_RETENTION (default 7 hari).
    Entry tanpa timestamp dibiarkan tetap ada.
    """
    cutoff = datetime.now() - HISTORY_RETENTION
    cleaned = []
    for item in history:
        ts = parse_timestamp(item.get('created_at'))
        if ts is None or ts >= cutoff:
            cleaned.append(item)
    return cleaned


# =============================
# MAIN
# =============================
def main():
    if len(sys.argv) < 3:
        print(json.dumps({
            "clean_text": None,
            "status": "Error",
            "is_spam": 0,
            "is_kasar": 0,
            "skor_cosine": 0
        }))
        return

    input_text = sys.argv[1]
    file_path  = sys.argv[2]
    nama_user  = sys.argv[3] if len(sys.argv) > 3 else "Anonim"

    is_anonim = (nama_user.lower() == "anonim")

    # =========================
    # LOAD & NORMALIZE HISTORY
    # =========================
    try:
        with open(file_path, 'r', encoding='utf-8') as f:
            raw_history = json.load(f)
    except Exception:
        raw_history = []

    all_history = normalize_history(raw_history)

    # Bersihkan entry lama supaya file tidak terus membesar
    all_history = bersihkan_history(all_history)

    # =========================
    # PREPROCESS INPUT
    # =========================
    tokens    = preprocess(input_text)
    tokens    = map_angka(tokens)
    clean_text = " ".join(tokens)

    # =========================
    # DETEKSI KASAR & SPAM
    # =========================
    is_kasar = check_kasar(tokens)
    is_spam  = check_spam(input_text)

    # =========================
    # KATEGORI PANJANG TEKS
    # =========================
    if len(tokens) <= 2:
        kategori = "short"
    elif len(tokens) <= 5:
        kategori = "medium"
    else:
        kategori = "long"

    # =========================
    # FILTER HISTORY RELEVAN
    # Duplikat hanya dicek dalam window waktu sesuai kategori.
    # Untuk user teridentifikasi, hanya bandingkan dengan
    # komentar dari user yang sama supaya lebih adil.
    # =========================
    now    = datetime.now()
    window = TIME_WINDOWS[kategori]

    def dalam_window(item):
        ts = parse_timestamp(item.get('created_at'))
        return ts is not None and (now - ts) <= window

    relevant_history = [item for item in all_history if dalam_window(item)]

    # Untuk user teridentifikasi: filter per user
    if not is_anonim:
        relevant_history = [
            item for item in relevant_history
            if item.get('user') == nama_user
        ]

    # =========================
    # CEK DUPLIKAT
    # =========================
    max_cosine   = 0.0
    is_duplicate = False

    for old in relevant_history:
        old_text = old.get('text', '')

        # Exact match → langsung duplikat
        if clean_text == old_text:
            is_duplicate = True

        score = hitung_cosine(clean_text, old_text)
        if score > max_cosine:
            max_cosine = score

        # Threshold cosine sesuai kategori
        if kategori == "long"   and score >= 0.8:
            is_duplicate = True
        elif kategori == "medium" and score >= 0.9:
            is_duplicate = True
        elif kategori == "short"  and score == 1.0:
            is_duplicate = True

    # =========================
    # CEK SPAM KHUSUS ANONIM
    # Dalam window 40 detik, anonim yang kirim konten
    # berulang atau identik berkali-kali dianggap spam.
    # =========================
    if is_anonim and clean_text:
        recent_window   = timedelta(seconds=40)
        recent_comments = [
            item for item in all_history
            if item.get('created_at') and
            (now - parse_timestamp(item['created_at'])) <= recent_window
        ]

        tokens_clean    = clean_text.split()
        repeated_words  = [w for w, cnt in Counter(tokens_clean).items() if cnt > 1]

        if repeated_words:
            repeat_hits = sum(
                1 for entry in recent_comments
                if any(word in entry.get('text', '').split() for word in repeated_words)
            )
            if repeat_hits >= 2:
                is_spam      = True
                is_duplicate = True

        same_recent_count = sum(
            1 for entry in recent_comments
            if entry.get('text') == clean_text
        )
        if same_recent_count >= 2:
            is_spam      = True
            is_duplicate = True

    # =========================
    # PRIORITY LOGIC
    # Kasar > Spam > Duplikat > Approved
    # =========================
    if is_kasar:
        status = "Rejected"
    elif is_spam:
        status = "Spam"
    elif is_duplicate:
        status = "Duplikat"
    else:
        status = "Approved"

    # =========================
    # SIMPAN HISTORY (dengan user)
    # =========================
    try:
        all_history.append({
            'text':       clean_text,
            'user':       nama_user,
            'created_at': datetime.now().isoformat(),
        })
        with open(file_path, 'w', encoding='utf-8') as f:
            json.dump(all_history, f, ensure_ascii=False, indent=2)
    except Exception:
        pass

    # =========================
    # OUTPUT
    # =========================
    result = {
        "clean_text":  clean_text,
        "status":      status,
        "is_spam":     int(is_spam),
        "is_kasar":    int(is_kasar),
        "skor_cosine": round(max_cosine, 3),
    }

    print(json.dumps(result, ensure_ascii=False))


# =============================
# ENTRY POINT
# =============================
if __name__ == "__main__":
    main()