# Instructions

## Quick Overview
1. Create a repository using the provided templates at [https://git.taitaja.webkehitys.fi](https://git.taitaja.webkehitys.fi). It is important to use the given templates as they include Gitea Actions functionality and will automatically deploy your work upon push.
2. Clone the project and work locally. Commit frequently but only push when a larger feature is ready. Each push takes time to deploy (e.g., Next.js and Laravel up to 2 minutes). Be patient.
3. You can use phpMyAdmin at [https://pma.taitaja.webkehitys.fi](https://pma.taitaja.webkehitys.fi).

---

## 1. Create a New Repository

- Go to the Git server: [https://git.taitaja.webkehitys.fi](https://git.taitaja.webkehitys.fi).
- Log in with your username and password.
- Navigate to **Organization → Frameworks**.
  
  ![orgs](/semifinaali/instructions/orgs.png)

- Select the framework you want to use or the "vanilla" template.
- Click **"Use this template"** to create a new repository.
- Name the repository according to the module name: **frontend** or **backend**. For vanilla projects, name the repository **frontend**.
  
  ![secrets settings](/semifinaali/instructions/new_repo.png)

- Open your repository settings: **Settings → Actions → Secrets**.
- Add the following:
  - **USER:** Your username (e.g., comp01)
  - **PASS:** Your password (e.g., test123)

  ![secrets settings](/semifinaali/instructions/add-secret.png)
  
  ![secrets settings](/semifinaali/instructions/secrets.png)

- Commit and verify that Gitea Actions is working correctly.
- Check your changes at the URL:
  
  ```
  https://<subdomain>-<module_name>.taitaja.webkehitys.fi
  ```

> Each competitor is assigned a username, password, and alias.
> The alias forms the subdomain address used in the competition environment.
>
> For example, alias **`skdjf`** appears as:
>
> - Frontend: https://skdjf-frontend.taitaja.webkehitys.fi
> - Backend: https://skdjf-backend.taitaja.webkehitys.fi

---

## 2. Clone the Repository and Work

**Clone the repository:**
- Use the repository URL to clone:
  
  ```bash
  git clone https://git.taitaja.webkehitys.fi/<username>/<module_name>.git
  ```
  **Example:**
  ```bash
  git clone https://git.taitaja.webkehitys.fi/comp01/frontend.git
  ```

**Edit, commit, and develop:**
- Commit regularly to keep your work organized.
- Update the **README file** with important information like installation instructions and dependencies.

---

## 3. Using phpMyAdmin

**Access phpMyAdmin:**
- Go to [https://pma.taitaja.webkehitys.fi](https://pma.taitaja.webkehitys.fi).
- Log in with your username and password.

**Database connection:**
- Use the following host setting to connect to the database:
  
  ```php
  define('DB_HOST', 'db.taitaja.webkehitys.fi');
  ```

Each user has predefined databases:

```
username_frontend
username_backend
```
  **Example:**
```
comp01_frontend
comp02_backend
```

---

## 4. Automation and Deployment

- Each **push** automatically deploys to the competition URL:
  
  ```
  https://<subdomain>-<module_name>.taitaja.webkehitys.fi
  ```

- Avoid unnecessary pushes to limit deployments.
- Check your changes at the competition URL after each push.

---

> Each student is assigned a username, password, and alias.
> The alias forms the subdomain address used in the competition environment.
>
> For example, alias **`skdjf`** appears as:
>
> - Frontend: https://skdjf-frontend.taitaja.webkehitys.fi
> - Backend: https://skdjf-backend.taitaja.webkehitys.fi

