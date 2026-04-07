import pandas as pd
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.naive_bayes import MultinomialNB
import joblib
import os

def train_from_csv():
    try:
        # 1. Load CSV
        path = os.path.dirname(os.path.abspath(__file__))
        csv_path = os.path.join(path, 'dataset_ulasan.csv')

        df = pd.read_csv(csv_path)

        if df.empty:
            print("Dataset kosong!")
            return

        # 2. Ambil data
        X_text = df['ulasan']
        y = df['sentimen']

        # 3. TF-IDF
        vectorizer = TfidfVectorizer()
        X = vectorizer.fit_transform(X_text)

        # 4. Model Naive Bayes
        model = MultinomialNB()
        model.fit(X, y)

        # 5. Simpan model
        model_path = os.path.join(path, 'model')
        if not os.path.exists(model_path):
            os.makedirs(model_path)

        joblib.dump(model, os.path.join(model_path, 'naive_bayes_model.pkl'))
        joblib.dump(vectorizer, os.path.join(model_path, 'tfidf_vectorizer.pkl'))

        print("✅ Model berhasil dibuat!")

    except Exception as e:
        print("Error:", e)

if __name__ == "__main__":
    train_from_csv()