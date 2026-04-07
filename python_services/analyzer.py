import sys
import json
import joblib
import os

def analyze():
    if len(sys.argv) < 2: return

    try:
        # Menerima ulasan yang sudah di-filter (clean) dari Laravel
        input_ulasan = json.loads(sys.argv[1]) 
        
        path = os.path.dirname(os.path.abspath(__file__))
        model = joblib.load(os.path.join(path, 'model/naive_bayes_model.pkl'))
        vectorizer = joblib.load(os.path.join(path, 'model/tfidf_vectorizer.pkl'))

        # Langsung prediksi tanpa cleaning tambahan
        tfidf_matrix = vectorizer.transform(input_ulasan)
        predictions = model.predict(tfidf_matrix)

        print(json.dumps(list(predictions)))

    except Exception as e:
        import traceback
        print("ERROR_PYTHON:", str(e))
        traceback.print_exc()

if __name__ == "__main__":
    analyze()