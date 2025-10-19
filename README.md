# 🤝 FreelanceConnect

[![Status](https://img.shields.io/badge/status-active-success.svg)]()
[![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?logo=javascript&logoColor=black)]()
[![Symfony](https://img.shields.io/badge/Symfony-339933?logo=symfony&logoColor=white)]()

> Plateforme web moderne permettant de connecter clients et freelances pour faciliter la publication et la gestion de missions professionnelles.

## 📋 Table des matières

- [À propos](#à-propos)
- [Fonctionnalités](#fonctionnalités)
- [Technologies utilisées](#technologies-utilisées)
- [Installation](#installation)
- [Utilisation](#utilisation)
- [Captures d'écran](#captures-décran)
- [Roadmap](#roadmap)
- [Contribution](#contribution)
- [Auteur](#auteur)

## 🎯 À propos
FreelanceConnect est une plateforme web full-stack conçue pour simplifier la mise en relation entre clients et freelances. Le projet répond à un besoin réel de centralisation des opportunités de missions et permet une gestion complète du cycle de vie d'une mission, de la publication à l'attribution.

### Contexte du projet

Ce projet a été développé dans le cadre de mes études en Licence Informatique à l'Université de La Rochelle. Il illustre mes compétences en développement web full-stack et en conception d'applications métier.

## ✨ Fonctionnalités

### Pour les clients
- 📝 **Publication de missions** : Création et gestion de missions avec descriptions détaillées
- 👥 **Gestion des candidatures** : Consultation et sélection des candidatures reçues
- 💬 **Messagerie intégrée** : Communication directe avec les freelances
- 📊 **Tableau de bord** : Vue d'ensemble de toutes les missions actives

### Pour les freelances
- 🔍 **Recherche de missions** : Système de filtres
- 🎯 **Candidatures simplifiées** : Postulation en un clic 

### Fonctionnalités communes
- 🔐 **Authentification sécurisée** : Système de connexion/inscription avec JWT
- 📱 **Responsive design** : Interface adaptée à tous les écrans

## 🛠️ Technologies utilisées

### Frontend
- **JavaScript** (ES6+)
- **HTML5** / **CSS3**
- **Bootstrap** ou framework CSS utilisé

### Backend
- **Symfony** - Framework web
- **MongoDB** / **MySQL** - Base de données 

### Outils
- **Git** / **GitHub** - Versioning
- **npm** - Gestion des dépendances

## 🚀 Installation

### Prérequis

Assurez-vous d'avoir installé :
- [npm](https://www.npmjs.com/) ou [yarn](https://yarnpkg.com/)
- [MongoDB](https://www.mongodb.com/) ou MySQL (selon votre configuration)

### Étapes d'installation

1. **Cloner le repository**
```bash
git clone https://github.com/Gery-Charles/FreelanceConnect.git
cd FreelanceConnect
```

2. **Installer les dépendances**
```bash
npm install
```

3. **Configuration de l'environnement**

Créez un fichier `.env` à la racine du projet :
```env
PORT=3000
DB_URI=your_database_connection_string
JWT_SECRET=your_secret_key
NODE_ENV=development
```

### Mode développement

Pour lancer en mode développement avec rechargement automatique :
```bash
npm run dev
```

## 💻 Utilisation

### Créer un compte

1. Accédez à la page d'inscription
2. Choisissez votre type de compte (Client ou Freelance)
3. Remplissez vos informations
4. Validez votre email

### Publier une mission (Client)

1. Connectez-vous à votre compte
2. Cliquez sur "Nouvelle mission"
3. Remplissez les détails (titre, description, budget, délais)
4. Publiez la mission

### Postuler à une mission (Freelance)

1. Parcourez les missions disponibles
2. Utilisez les filtres pour affiner votre recherche
3. Cliquez sur une mission qui vous intéresse
4. Soumettez votre candidature

## 👨‍💻 Auteur

**Charles Géry**

- GitHub: [@Gery-Charles](https://github.com/Gery-Charles)
- Portfolio: [gery-charles.github.io/portfolio](https://gery-charles.github.io/portfolio/)
- LinkedIn: [www.linkedin.com/in/charles-gery]

---

<div align="center">

**⭐ Si ce projet vous a été utile, n'hésitez pas à lui donner une étoile !**

Made with ❤️ by Charles Gery

</div>
