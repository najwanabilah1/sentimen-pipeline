#!/usr/bin/env python3
# -*- coding: utf-8 -*-

import pandas as pd
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.naive_bayes import MultinomialNB
import joblib
import os

def train_from_csv():
    try:
        # =========================
        # 1. LOAD DATASET
        # =========================
        path = os.path.dirname(os.path.abspath(__file__))
        csv_path = os.path.join(path, 'dataset_ulasan.csv')

        if not os.path.exists(csv_path):
            print("❌ File dataset tidak ditemukan!")
            return

        df = pd.read_csv(csv_path)

        if df.empty:
            print("❌ Dataset kosong!")
            return

        # =========================
        # 2. CLEAN DATA
        # =========================
        df = df.dropna(subset=['ulasan', 'sentimen'])
        df['ulasan'] = df['ulasan'].astype(str)

        # =========================
        # 3. AMBIL FITUR
        # =========================
        X_text = df['ulasan']
        y = df['sentimen']

        # =========================
        # 4. TF-IDF VECTORIZER
        # =========================
        vectorizer = TfidfVectorizer(
            lowercase=True,
            ngram_range=(1,2),   # bigram biar lebih akurat
            max_features=5000
        )

        X = vectorizer.fit_transform(X_text)

        # =========================
        # 5. MODEL NAIVE BAYES
        # =========================
        model = MultinomialNB()
        model.fit(X, y)

        # =========================
        # 6. SIMPAN MODEL
        # =========================
        model_path = os.path.join(path, 'model')

        if not os.path.exists(model_path):
            os.makedirs(model_path)

        joblib.dump(model, os.path.join(model_path, 'naive_bayes_model.pkl'))
        joblib.dump(vectorizer, os.path.join(model_path, 'tfidf_vectorizer.pkl'))

        print("✅ Model berhasil dibuat & disimpan!")

    except Exception as e:
        print("❌ Error:", str(e))


if __name__ == "__main__":
    train_from_csv()