from TELEFON.api import A
import sys
from concurrent.futures import ThreadPoolExecutor, as_completed

def main():
    if len(sys.argv) < 2:
        print("Lütfen telefon numarası girin")
        sys.exit(1)

    tel_no = sys.argv[1]
    sender = A(tel_no)

    api_methods = [method for method in dir(sender) 
                   if callable(getattr(sender, method)) and not method.startswith("__")]

    print(f"Toplam API fonksiyonu: {len(api_methods)}")

    def run_method(name):
        method = getattr(sender, name)
        try:
            method()
            return f"{name}: Başarılı"
        except Exception as e:
            return f"{name}: Hata -> {e}"

    with ThreadPoolExecutor(max_workers=5) as executor:  # max_workers arttırılabilir
        futures = [executor.submit(run_method, m) for m in api_methods]

        for future in as_completed(futures):
            print(future.result())

    print("Tüm API fonksiyonları paralel olarak çalıştırıldı.")

if __name__ == "__main__":
    main()
