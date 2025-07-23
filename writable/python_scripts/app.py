import sys
import json
import pandas as pd
import numpy as np
import matplotlib.pyplot as plt
from statsmodels.tsa.seasonal import seasonal_decompose
import io
import base64
import pymysql
from flask import Flask, request, jsonify
from flask_cors import CORS # Penting untuk mengizinkan permintaan dari domain lain (CI4)

app = Flask(__name__)
CORS(app) # Mengaktifkan CORS untuk semua rute

# Konfigurasi database (pindahkan ke sini)
db_config = {
    'host': 'localhost',
    'user': 'root',
    'password': '', # Pastikan ini benar (kosong jika tidak ada password)
    'database': 'polatidur_db'
}

@app.route('/analyze-sleep-data', methods=['POST'])
def analyze_sleep_data():
    """
    Endpoint API untuk melakukan analisis deret waktu pada data tidur.
    Mengambil data langsung dari database.
    """
    try:
        # Koneksi ke database dan ambil data
        conn = pymysql.connect(**db_config)
        df = pd.read_sql("SELECT tanggal, durasi_tidur, kualitas_tidur FROM data_tidur ORDER BY tanggal ASC", conn)
        conn.close()

        if df.empty:
            return jsonify({
                "status": "error",
                "message": "Tidak ada data yang ditemukan di database untuk analisis."
            }), 400 # Bad Request

        # Pastikan kolom 'tanggal' adalah datetime dan dijadikan index
        df['tanggal'] = pd.to_datetime(df['tanggal'])
        df = df.set_index('tanggal').sort_index()

        # --- Analisis Dasar ---
        summary_stats = df[['durasi_tidur', 'kualitas_tidur']].describe().to_json()

        # --- Dekomposisi Deret Waktu (Contoh untuk Durasi Tidur) ---
        decomposition = None
        try:
            if len(df) > 2 * 7: # Minimal 2 periode untuk dekomposisi mingguan
                decomposition = seasonal_decompose(df['durasi_tidur'], model='additive', period=7)
            else:
                print("Warning: Data terlalu pendek untuk dekomposisi musiman (membutuhkan setidaknya 2 periode).", file=sys.stderr)
        except Exception as e:
            print(f"Warning: Dekomposisi gagal - {e}", file=sys.stderr)

        # --- Visualisasi ---
        plt.figure(figsize=(12, 6))
        plt.plot(df.index, df['durasi_tidur'], label='Durasi Tidur (Jam)', color='#78350F') # Warna coklat
        plt.plot(df.index, df['kualitas_tidur'], label='Kualitas Tidur (1-10)', color='#B45309') # Warna coklat lebih terang
        plt.title('Pola Waktu Tidur', color='#44403C')
        plt.xlabel('Tanggal', color='#44403C')
        plt.ylabel('Nilai', color='#44403C')
        plt.legend()
        plt.grid(True, linestyle='--', alpha=0.7)
        plt.tight_layout()

        # Konversi plot ke base64
        buf = io.BytesIO()
        plt.savefig(buf, format='png')
        buf.seek(0)
        plot_base64 = base64.b64encode(buf.getvalue()).decode('utf-8')
        plt.close() # Tutup plot untuk menghemat memori

        # --- Peramalan (Contoh Sederhana/Placeholder) ---
        forecast_value = df['durasi_tidur'].tail(7).mean() if len(df) >= 7 else df['durasi_tidur'].mean()
        forecast_text = f"Peramalan durasi tidur rata-rata 7 hari ke depan: {forecast_value:.2f} jam."

        # Siapkan hasil untuk dikembalikan dalam format JSON
        result = {
            "status": "success",
            "summary": json.dumps(json.loads(summary_stats), indent=2),
            "plot_base64": plot_base64,
            "forecast": forecast_text
        }
        return jsonify(result), 200 # Mengembalikan JSON dan status OK

    except pymysql.Error as db_err:
        print(f"ERROR: Terjadi kesalahan database: {str(db_err)}", file=sys.stderr)
        return jsonify({
            "status": "error",
            "message": f"Terjadi kesalahan database: {str(db_err)}"
        }), 500 # Internal Server Error
    except Exception as e:
        print(f"ERROR: Terjadi kesalahan umum dalam analisis Python: {str(e)}", file=sys.stderr)
        return jsonify({
            "status": "error",
            "message": f"Terjadi kesalahan dalam analisis Python: {str(e)}"
        }), 500 # Internal Server Error

if __name__ == '__main__':
    # Jalankan aplikasi Flask
    # Untuk pengembangan, bisa langsung: python app.py
    # Untuk produksi, gunakan gunicorn: gunicorn -w 4 app:app -b 0.0.0.0:5000
    app.run(debug=True, port=5000) # debug=True hanya untuk pengembangan
