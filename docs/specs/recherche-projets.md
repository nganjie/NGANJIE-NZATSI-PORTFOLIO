# Recherche sur les projets (octobre 2026)

Sources utilisées pour écrire le contenu initial des projets (`database/seeders/data/projects.php`) :

1. le **CV** de Nganjie Nzatsi (version d'octobre 2026) ;
2. le document de contexte du projet ;
3. une recherche web publique sur chaque produit.

**Limite** : les sites eux-mêmes n'étaient pas accessibles depuis l'environnement de développement (proxy réseau). Les informations viennent des résultats de recherche, de NuGet et des dépôts GitHub publics. **Aucun chiffre n'a été repris dans le site** (les chiffres affichés par certains produits ne sont pas vérifiés).

## Ce que dit le CV

- **SIGP SC Cameroun Sarl**, Douala : développeur full stack C# .NET / Angular en alternance depuis **février 2024**. Suite de logiciels : sigpsc.com, ssmp.sigpsc.com, EXBILCORE, aladjhub.com, sportbetafrica.com, africaexchanges.com. Back-end .NET (jusqu'à .NET 10) : API REST, services, webhooks, jobs planifiés, tests unitaires. Front-end Angular 17 à 22.
- **PayOol et PrismCard** (janvier à mai 2024) : développeur full stack Laravel, fintech. Cartes virtuelles Visa et Mastercard, recharges, architecture multi-API, intégrations SoleasPay, Eversend, Strowallet, marketplace.
- **MikrotekNetwork** (février à juin 2023) : développeur front-end. Refonte du front-end, serveur Node.js de notifications en temps réel par WebSocket.
- **Formation** : cycle ingénieur en génie logiciel par alternance, ENSPD (2024-2027) ; licence d'informatique, Université de Douala (2021-2024) ; baccalauréat C mention Bien, Lycée de Njombé (2021).
- **Recherche** : stage de fin d'études de 6 mois à partir de janvier 2027, idéalement en banque ou finance.

## Produits

| Produit | Ce qui a été trouvé | Utilisation dans le seed |
|---|---|---|
| **SmartSchools** | SaaS multi-établissements : inscriptions, dossier élève, notes et bulletins, scolarité, emplois du temps, portail parent, SMS et e-mail, rôles, journal d'audit. Page produit sur sigpsc.com. | Publié, à la une |
| **ExbilCore** | API unifiée : agrégation Orange Money / MTN MoMo, SMS / WhatsApp / Telegram / e-mail, MFA (OTP, TOTP). SDK .NET `ExbilCoreSdk` publié sur NuGet (dépôt github.com/sigpsc/ExbilCoreSdk). aladjpay.com porte le titre « EXBILCORE - Backoffice ». | Publié, à la une |
| **SportBetAfrica** | Paris sportifs camerounais (football surtout), paris en direct, dépôts et retraits par MTN / Orange Money ou en agence. La marque blanche, la caisse et l'application mobile viennent du document de contexte. | Publié, à la une |
| **PayOol** | Cartes virtuelles Visa et Mastercard rechargées par Mobile Money, pour particuliers et entreprises. Le site met en avant des cartes « sans KYC » : **volontairement non repris** (sujet sensible pour un public bancaire). | Publié, à la une |
| **PrismCard** | Cartes de débit virtuelles, abonnements, paiements internationaux, marketplace (prism.payool.net). | Publié |
| **AladjHub** | Plateforme de gestion financière par abonnement : agences, encaissements et retraits, trésorerie, prêts, wallet mobile. La recherche cite l'éditeur AfrisoftSolutions Sarl ; le CV le place dans la suite SIGP SC. Prix non repris (incohérents). | Publié, à vérifier (Q8) |
| **Site sigpsc.com** | Site de l'entreprise : services, solutions cloud, catalogue de produits. | Publié |
| **MikroTek Network** | Portail de connexion visible ; dépôts publics MikrotekWifiService et MikrotekWifiBCAUI. | Publié |
| **AfricaExchanges** | Aucun contenu public trouvé. | Brouillon, à compléter |
| **SSMP** | Aucun contenu public trouvé. | Brouillon, à compléter |

## Dépôts GitHub publics notables (non repris)

UniversityCoursPlanningBackend, GestionNotesEtudiant (.NET MAUI), Superbet237, point10rechargelaravel, snapFaceAPP, tinyhttp (Rust)… Ils peuvent devenir des projets « Académique » ou « Personnel » depuis l'administration si Nganjie le souhaite.

## API de paiement citées

- **SoleasPay** : passerelle de paiement Mobile Money camerounaise.
- **Eversend** : fintech (Ouganda, équipe à Yaoundé) ; collecte, paiements vers Mobile Money et banques, change.
- **Strowallet** : fintech nigériane ; émission de cartes virtuelles et comptes virtuels par API.
