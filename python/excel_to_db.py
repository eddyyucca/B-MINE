import pandas as pd
import mysql.connector
from mysql.connector import Error

def masukkan_data_ke_mysql():
    try:
        # Baca file Excel
        print("Membaca file Excel...")
        file_path = 'data_karyawan.xlsx'  # Pastikan nama file sesuai
        df = pd.read_excel(file_path)
        
        # Koneksi ke MySQL
        print("Menghubungkan ke MySQL...")
        koneksi = mysql.connector.connect(
            host='localhost',
            port=3307,  # Port default MySQL adalah 3306
            user='root',
            password='',
            database='bmine'
        )
        
        if koneksi.is_connected():
            cursor = koneksi.cursor()
            
            # Buat tabel karyawan
            print("Membuat tabel karyawan...")
            create_table_query = """
            CREATE TABLE IF NOT EXISTS karyawan (
                id_kar INT PRIMARY KEY,
                nik VARCHAR(20),
                nama VARCHAR(100),
                departement VARCHAR(100),
                jabatan VARCHAR(100),
                status_mp VARCHAR(20),
                password VARCHAR(100),
                LEVEL VARCHAR(20)
            )
            """
            cursor.execute(create_table_query)
            
            # Hapus data yang ada (opsional)
            cursor.execute("DELETE FROM karyawan")
            
            # Masukkan data baru
            print("Memasukkan data...")
            for _, row in df.iterrows():
                insert_query = """
                INSERT INTO karyawan (id_kar, nik, nama, departement, jabatan, status_mp, password, level)
                VALUES (%s, %s, %s, %s, %s, %s, %s, %s)
                """
                values = (
                    int(row['id_kar']),
                    str(row['nik']),
                    str(row['nama']),
                    str(row['departement']),
                    str(row['jabatan']),
                    str(row['status_mp']),
                    str(row['password']),
                    str(row['level'])
                )
                cursor.execute(insert_query, values)
            
            # Commit perubahan
            koneksi.commit()
            print("Data berhasil dimasukkan ke MySQL!")
            
            # Tampilkan jumlah data yang dimasukkan
            cursor.execute("SELECT COUNT(*) FROM karyawan")
            count = cursor.fetchone()[0]
            print(f"Jumlah data yang dimasukkan: {count}")
            
    except Error as e:
        print(f"Terjadi kesalahan: {e}")
    
    finally:
        if 'koneksi' in locals() and koneksi.is_connected():
            cursor.close()
            koneksi.close()
            print("Koneksi MySQL ditutup")

def cek_data():
    try:
        koneksi = mysql.connector.connect(
                host='localhost',
                port=3307,  # Port default MySQL adalah 3306
                username='root',
                password='',
                database='bmine'
        )
        cursor = koneksi.cursor()
        
        # Tampilkan 5 data pertama
        cursor.execute("SELECT * FROM karyawan LIMIT 5")
        rows = cursor.fetchall()
        
        print("\nContoh 5 data pertama:")
        for row in rows:
            print(f"""
id_kar: {row[0]}
nik: {row[1]}
nama: {row[2]}
departement: {row[3]}
jabatan: {row[4]}
status_mp: {row[5]}
password: {row[6]}
level: {row[7]}
------------------""")
            
    except Error as e:
        print(f"Terjadi kesalahan saat mengecek data: {e}")
    finally:
        if 'koneksi' in locals() and koneksi.is_connected():
            cursor.close()
            koneksi.close()

if __name__ == "__main__":
    print("Program Import Data Excel ke MySQL")
    print("="*40)
    
    masukkan_data_ke_mysql()
    cek_data()