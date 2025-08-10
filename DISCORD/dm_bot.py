import discord
from discord.ext import commands
import asyncio
import sys
import json
import base64

intents = discord.Intents.default()
intents.message_content = True

async def dm_bot(token, hedef_kullanici_id, mesaj, adet):
    bot = commands.Bot(command_prefix="!", intents=intents)

    @bot.event
    async def on_ready():
        print(f"[{bot.user}] Aktif ve DM göndermeye başlıyor...")
        try:
            user = await bot.fetch_user(int(hedef_kullanici_id))
        except Exception as e:
            print(f"[{bot.user}] Hedef kullanıcı alınamadı: {e}")
            await bot.close()
            return

        sent = 0
        try:
            dm = await user.create_dm()
            for _ in range(adet):
                await dm.send(mesaj)
                sent += 1
                print(f"[{bot.user}] {sent}/{adet} mesaj gönderildi.")
                await asyncio.sleep(1)
        except discord.Forbidden:
            print(f"[{bot.user}] DM gönderme yetkisi yok veya kullanıcı DM kapalı.")
        except Exception as e:
            print(f"[{bot.user}] Mesaj gönderme hatası: {e}")

        print(f"[{bot.user}] Görev tamamlandı, çıkılıyor.")
        await bot.close()

    try:
        await bot.start(token)
    except discord.LoginFailure:
        print(f"[{token[:10]}...] Geçersiz token!")
    except Exception as e:
        print(f"[{token[:10]}...] Bot başlatma hatası: {e}")

async def main():
    if len(sys.argv) < 5:
        print("Kullanım: python dm_bot.py <tokens_base64> <hedef_kullanici_id> <mesaj> <adet>")
        return

    tokens_base64 = sys.argv[1]
    hedef_kullanici_id = sys.argv[2]
    mesaj = sys.argv[3]
    adet = int(sys.argv[4])

    try:
        tokens_json = base64.b64decode(tokens_base64).decode('utf-8')
        tokens = json.loads(tokens_json)
    except Exception as e:
        print(f"Tokenlar base64 decode ya da JSON parse edilemedi: {e}")
        return

    print(f"Bot sayısı: {len(tokens)}")
    print(f"Her bot {adet} mesaj gönderecek.")
    print(f"Hedef kullanıcı ID: {hedef_kullanici_id}")
    print(f"Mesaj: {mesaj}")
    print("Botlar mesaj gönderimini başlatıyor...")

    await asyncio.gather(*(dm_bot(token, hedef_kullanici_id, mesaj, adet) for token in tokens))

if __name__ == "__main__":
    asyncio.run(main())
