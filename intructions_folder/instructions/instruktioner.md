# Instruktioner

## Snabb Översikt
1. Skapa ett repo med hjälp av de tillhandahållna mallarna på [https://git.taitaja.webkehitys.fi](https://git.taitaja.webkehitys.fi). Det är viktigt att använda de givna mallarna eftersom de innehåller Gitea Actions-funktioner och automatiskt publicerar ditt arbete vid push.
2. Klona projektet och arbeta lokalt. Commita ofta, men pusha bara när en större del är klar. Varje push tar tid att publicera (t.ex. Next.js och Laravel upp till 2 minuter). Ha tålamod.
3. Du kan använda phpMyAdmin vid behov på [https://pma.taitaja.webkehitys.fi](https://pma.taitaja.webkehitys.fi).

---

## 1. Skapa ett nytt repo

- Gå till Git-servern: [https://git.taitaja.webkehitys.fi](https://git.taitaja.webkehitys.fi).
- Logga in med ditt användarnamn och lösenord.
- Navigera till **Organisation → Frameworks**.
  
  ![orgs](/semifinaali/instructions/orgs.png)

- Välj det ramverk du vill använda eller använd "vanilla"-mallen.
- Klicka på **"Use this template"** för att skapa ett nytt repo.
- Namnge repot efter modulnamnet: **frontend** eller **backend**. För vanilla-projekt, namnge repot **frontend**.

![secrets settings](/semifinaali/instructions/new_repo.png)

- Öppna inställningarna för ditt repo: **Settings → Actions → Secrets**.
- Lägg till följande:
  - **USER:** Ditt användarnamn (t.ex. comp01)
  - **PASS:** Ditt lösenord (t.ex. test123)

  ![secrets settings](/semifinaali/instructions/add-secret.png)
  
  ![secrets settings](/semifinaali/instructions/secrets.png)

- Commita och kontrollera att Gitea Actions fungerar korrekt.
- Kontrollera dina ändringar på URL:
  
  ```
  https://<subdomän>-<modulnamn>.taitaja.webkehitys.fi
  ```

> Varje student tilldelas ett användarnamn, ett lösenord och ett alias.
> Aliaset bildar subdomänen som används i tävlingsmiljön.
>
> Till exempel alias **`skdjf`** visas som:
>
> - Frontend: https://skdjf-frontend.taitaja.webkehitys.fi
> - Backend: https://skdjf-backend.taitaja.webkehitys.fi

---

## 2. Klona repot och arbeta

**Klona repot:**
- Använd repots URL för att klona:
  
  ```bash
  git clone https://git.taitaja.webkehitys.fi/<användarnamn>/<modulnamn>.git
  ```
  **Exempel:**

  ```bash
  git clone https://git.taitaja.webkehitys.fi/comp01/frontend.git
  ```

**Redigera, commita och utveckla:**
- Commita regelbundet för att hålla arbetet organiserat.
- Uppdatera **README-filen** med viktig information som installationsinstruktioner och beroenden.

---

## 3. Använda phpMyAdmin

**Öppna phpMyAdmin:**
- Gå till [https://pma.taitaja.webkehitys.fi](https://pma.taitaja.webkehitys.fi).
- Logga in med ditt användarnamn och lösenord.

**Databasanslutning:**
- Använd följande värdinställning för att ansluta till databasen:
  
  ```php
  define('DB_HOST', 'db.taitaja.webkehitys.fi');
  ```

Varje användare har förutbestämda databaser:

```
användarnamn_frontend
användarnamn_backend
```
  **Exempel:**
```
comp01_frontend
comp02_backend
```

---

## 4. Automation och distribution

- Varje **push** distribueras automatiskt till tävlings-URL:
  
  ```
  https://<subdomän>-<modulnamn>.taitaja.webkehitys.fi
  ```

- Undvik onödiga pushar för att begränsa distributioner.
- Kontrollera dina ändringar på tävlings-URL efter varje push.

---

> Varje student tilldelas ett användarnamn, ett lösenord och ett alias.
> Aliaset bildar subdomänen som används i tävlingsmiljön.
>
> Till exempel alias **`skdjf`** visas som:
>
> - Frontend: https://skdjf-frontend.taitaja.webkehitys.fi
> - Backend: https://skdjf-backend.taitaja.webkehitys.fi

