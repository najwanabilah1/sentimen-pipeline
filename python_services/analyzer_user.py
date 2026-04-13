#!/usr/bin/env python3
# -*- coding: utf-8 -*-

import sys
import os
import re
import json
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
# PREPROCESSING
# =============================
def preprocess(text):
    text = text.lower()
    text = re.sub(r'[^a-z0-9\s]', '', text)
    text = re.sub(r'(.)\1{2,}', r'\1\1', text)
    text = re.sub(r'\s+', ' ', text).strip()
    tokens = text.split()
    return tokens

def map_angka(tokens):
    mapping = {'1':'i','4':'a','5':'s','0':'o','3':'e'}
    new_tokens = []

    for word in tokens:
        if re.fullmatch(r'\d+', word):
            new_tokens.append(word)
        else:
            for k,v in mapping.items():
                word = word.replace(k,v)
            new_tokens.append(word)

    return new_tokens

def generate_ngrams(tokens, n=2):
    return [' '.join(tokens[i:i+n]) for i in range(len(tokens)-n+1)]

# =============================
# KASAR DETECTION
# =============================
def check_kasar(tokens):
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
    vectorizer = TfidfVectorizer().fit_transform([text1, text2])
    vectors = vectorizer.toarray()
    cosine = cosine_similarity(vectors)
    return cosine[0][1]

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
    file_path = sys.argv[2]
    nama_user = sys.argv[3] if len(sys.argv) > 3 else "Anonim"

    is_anonim = (nama_user.lower() == "anonim")

    # =========================
    # LOAD HISTORY
    # =========================
    try:
        with open(file_path, 'r', encoding='utf-8') as f:
            old_comments = json.load(f)
    except:
        old_comments = []

    # =========================
    # PREPROCESS
    # =========================
    tokens = preprocess(input_text)
    tokens = map_angka(tokens)
    clean_text = " ".join(tokens)

    # =========================
    # DETECTION
    # =========================
    is_kasar = check_kasar(tokens)
    is_spam = check_spam(input_text)

    status = "Approved"
    max_cosine = 0
    is_duplicate = False

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
    # DUPLICATE CHECK
    # =========================
    for old in old_comments:

        # exact match (paling kuat)
        if clean_text == old:
            if not is_anonim or kategori != "short":
                is_duplicate = True

        score = hitung_cosine(clean_text, old)

        if score > max_cosine:
            max_cosine = score

        if kategori == "long":
            if score >= 0.8:
                is_duplicate = True

        elif kategori == "medium":
            if score >= 0.9:
                is_duplicate = True

        elif kategori == "short":
            if not is_anonim and score == 1.0:
                is_duplicate = True

    # =========================
    # PRIORITY LOGIC
    # =========================
    if is_kasar:
        status = "Rejected"
    elif is_spam:
        status = "Spam"
    elif is_duplicate:
        status = "Duplikat"

    # =========================
    # SIMPAN HISTORY
    # =========================
    try:
        old_comments.append(clean_text)
        with open(file_path, 'w', encoding='utf-8') as f:
            json.dump(old_comments, f, ensure_ascii=False, indent=2)
    except:
        pass

    # =========================
    # OUTPUT
    # =========================
    result = {
        "clean_text": clean_text,
        "status": status,
        "is_spam": int(is_spam),
        "is_kasar": int(is_kasar),
        "skor_cosine": round(max_cosine, 3)
    }

    print(json.dumps(result, ensure_ascii=False))


# =============================
# ENTRY POINT
# =============================
if __name__ == "__main__":
    main()