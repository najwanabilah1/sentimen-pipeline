#!/usr/bin/env python3
# -*- coding: utf-8 -*-

import sys
import json
import joblib
import os
import warnings

# 🔥 Hilangkan warning sklearn
warnings.filterwarnings("ignore")

def analyze():
    try:
        # =========================
        # VALIDASI ARGUMEN
        # =========================
        if len(sys.argv) < 2:
            print(json.dumps({
                "success": False,
                "error": "Tidak ada input"
            }))
            return

        raw_input = sys.argv[1]

        # =========================
        # HANDLE INPUT (FLEKSIBEL)
        # =========================
        try:
            input_ulasan = json.loads(raw_input)

            if isinstance(input_ulasan, str):
                input_ulasan = [input_ulasan]

            if not isinstance(input_ulasan, list):
                input_ulasan = [str(input_ulasan)]

        except:
            input_ulasan = [raw_input]

        # =========================
        # LOAD MODEL
        # =========================
        path = os.path.dirname(os.path.abspath(__file__))

        model_path = os.path.join(path, 'model', 'naive_bayes_model.pkl')
        vectorizer_path = os.path.join(path, 'model', 'tfidf_vectorizer.pkl')

        if not os.path.exists(model_path):
            print(json.dumps({
                "success": False,
                "error": "Model tidak ditemukan"
            }))
            return

        if not os.path.exists(vectorizer_path):
            print(json.dumps({
                "success": False,
                "error": "Vectorizer tidak ditemukan"
            }))
            return

        model = joblib.load(model_path)
        vectorizer = joblib.load(vectorizer_path)

        # =========================
        # PREDIKSI
        # =========================
        tfidf_matrix = vectorizer.transform(input_ulasan)
        predictions = model.predict(tfidf_matrix)

        # bersihkan hasil
        predictions = [str(p).strip().lower() for p in predictions]

        # =========================
        # OUTPUT
        # =========================
        print(json.dumps({
            "success": True,
            "sentiment": predictions
        }))

    except Exception as e:
        print(json.dumps({
            "success": False,
            "error": str(e)
        }))


# =============================
# ENTRY POINT
# =============================
if __name__ == "__main__":
    analyze()