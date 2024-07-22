
--
CREATE DATABASE RidaSolutions;
USE RidaSolutions;


DROP TABLE IF EXISTS `commmandes`;
CREATE TABLE IF NOT EXISTS `commmandes` (
  `id_commande` int NOT NULL AUTO_INCREMENT,
  `client_commande` varchar(20) COLLATE utf8mb3_unicode_ci NOT NULL,
  `st_commande` int DEFAULT NULL,
  `statut_commande` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `service_commande` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_commande`),
  KEY `st_commande` (`st_commande`)
) ENGINE=MyISAM AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;



INSERT INTO `commmandes` (`id_commande`, `client_commande`, `st_commande`, `statut_commande`, `service_commande`) VALUES
(39, '2', 26, 'Terminé', 'produit'),
(38, '2', 26, 'Annuler', 'produit'),
(37, '2', 27, 'Annuler', 'produit'),
(36, '2', 28, 'Annuler', 'produit'),
(40, '33', 1, 'supprimer', 'produit'),
(41, '2', 25, 'Annuler', 'produit'),
(42, '2', 28, 'pas encore', 'produit'),
(43, '2', 26, 'pas encore', 'produit'),
(44, '1', 28, 'Annuler', 'produit'),
(45, '107', 12, 'supprimer', 'produit'),
(46, '107', 6, 'supprimer', 'produit'),
(47, '5', 28, 'pas encore', 'produit');


DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id_prod` int NOT NULL AUTO_INCREMENT,
  `img_prod` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `Nom_prod` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `Des_prod` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `catégorie_prod` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `promo_prod` bigint NOT NULL,
  `prix_ori_prod` double NOT NULL,
  `Prix_prod` double NOT NULL,
  `Stock_prod` int NOT NULL,
  PRIMARY KEY (`id_prod`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;



INSERT INTO `products` (`id_prod`, `img_prod`, `Nom_prod`, `Des_prod`, `catégorie_prod`, `promo_prod`, `prix_ori_prod`, `Prix_prod`, `Stock_prod`) VALUES
(1, 'Tablette1.jpg', 'Samsung Galaxy Tab S9+', 'La Samsung Galaxy Tab S9+ est dotée d\'un écran AMOLED de 13 pouces avec une résolution élevée de 2800 x 1752 pixels, offrant des couleurs vives et des noirs profonds, idéal pour regarder des films, travailler ou jouer.', 'tablettes', 0, 2599, 2599, 300),
(2, 'airpod1.jpg', 'AirPods d\'Apple', 'Les AirPods d\'Apple sont des écouteurs sans fil au design élégant et minimaliste. Leur forme ergonomique offre un confort optimal, même lors d\'une utilisation prolongée.', 'accessoires', 0, 0, 500, 20),
(3, 'PC GAMER.jpg', 'PC Gamer', 'Un PC Gamer est équipé d\'un processeur puissant, comme un Intel Core i7/i9 ou un AMD Ryzen 7/9, capable de gérer les jeux les plus exigeants et de fournir une performance fluide et réactive.', 'ordinateurs_portables', 0, 0, 0, 40),
(4, 'iphone-15-pro.jpg', 'iPhone 15 Pro', 'L’écran de l’iPhone 15 Pro a des angles arrondis qui suivent la ligne élégante de l’appareil et s’inscrivent dans un rectangle standard. Si l’on mesure ce rectangle, l’écran affiche une diagonale de 6,12 pouces (la zone d’affichage réelle est moindre).', 'TÉLÉPHONIE', 0, 0, 15990, 300),
(5, 'Microsoft-365-Personnel-Francais-Afrique.webp', 'Microsoft 365 Personnel F', 'Microsoft 365 Personnel offre un abonnement pratique d’un an pour une personne, avec un service client disponible 24 heures sur 24, 7 jours sur 7, des sauvegardes automatiques et des nouvelles fonctionnalités et applications régulièrement mises à jour. Pr', 'LOGICIEL', 0, 0, 500, 1000),
(6, 'Galaxy-S23-Series.jpg', 'Samsung S23 Ultra', 'Le Samsung Galaxy S23 Ultra est le smartphone le plus haut de gamme de la série Galaxy S23. Il dispose d\'un écran de 6,8 pouces à 120Hz, et d’un stylet logé sous son boîtier. Il embarque le Soc Qualcomm Snapdragon 8 Gen 2, dispose de 8 ou 12', 'smartphone', 0, 0, 13999, 130),
(7, 'pc-portable-lenovo-ideapad-3-15igl05-celeron-4gb-1to-81wq00gtfe-768x768.png', 'Ordinateur Portable Lenov', 'Intel Celeron N4020 (2C / 2T, 1.1 / 2.8GHz, 4MB)\r\nRAM: 4GB Soldered DDR4-2400\r\nDisque dur: 1TB HDD 5400rpm 2.5″\r\nÉcran: 15.6″ HD (1366×768) TN 220nits Anti-glare\r\nCarte graphique: Intel UHD Graphics 600\r\nWindows 11 Home 64, French\r\nClavier: Français (AZER', 'ordinateurs_portables', 0, 0, 4.51, 300),
(8, '2887450-1200x1200-1.jpg', 'Ordinateur portable Asus ', '12th Gen Intel® Core™ i7-12700H Processor 2.3 GHz (24M Cache, up to 4.7 GHz, 14 cores: 6 P-cores and 8 E-cores)\r\nRAM: 16GB (8GB DDR5 on board + 8GB DDR5-4800 SO-DIMM)\r\nDisque dur: 512GB PCIe® 4.0 NVMe™ M.2 Performance SSD\r\nÉcran: 16″ FHD+ 16:10 (1920 x 12', 'ordinateurs_portables', 10, 0, 0, 139),
(10, 'Sans-tyt1-768x768.jpg', 'Norton Security Deluxe – ', 'Protège vos PC Windows, Mac et appareils Android et iOS avec un abonnement unique\r\n\r\nPermet d’offrir une protection en temps réel contre les malwares existants et émergents.\r\n\r\nVous signale les applications Android à risque avant que vous ne les télécharg', 'logiciels', 0, 0, 209.99, 15),
(11, 'Bitdefender-Internet-Security-1-Poste-1-an-768x768.webp', 'Bitdefender Internet Secu', 'Protégez votre PC Windows avec Bitdefender Internet Security, la meilleure suite de sécurité en ligne. Bloquez les attaques, grâce à une détection imbattable des menaces et un pare-feu efficace. Protégez votre vie privée avec la protection de la webcam et', 'logiciels', 0, 0, 0, 20),
(12, 'Nouveau-projet-2023-07-20T172636.198-768x768.webp', 'SAMSUNG Galaxy A14 4G (Du', 'Écran: PLS LCD\r\nTaille écran: 66″ (167.2mm)\r\nProcesseur: Octa-Core 2GHz, 1.8GHz\r\nMémoire: RAM 4 Go – 128 GB stockage\r\nCarte mémoire: MicroSD (Jusqu’à 1TB)\r\nAppareil photo: Caméra Principale : 50.0 MP + 5.0 MP + 2.0 MP / F1.8 , F2.2 , F2.4 / Auto Focus / D', 'smartphone', 5, 3600, 3420, 20),
(13, 'dolibar-origi-768x768.jpg', 'Dolibarr ERP/CRM', 'Livraison rapide sur tout le Maroc (50 DH TTC)\r\nOù que vous soyez au Maroc, nous vous livrons dans de brefs délais.', 'logiciels', 0, 0, 0, 45),
(18, 'kaspersky-small-office-security2.jpg', 'Kaspersky Small Office Se', 'Kaspersky Small Office Security 8.0-1 Serv+10 post KL45418BKFS-20MWCA', 'logiciels', 0, 2500, 2500, 200),
(19, 'Microsoft-365-Personnel-Francais-Afrique.webp', 'Microsoft 365 Personnel Français Afrique – 1 an / 1 PC (QQ2-', 'Microsoft 365 Personnel offre un abonnement pratique d’un an pour une personne, avec un service client disponible 24 heures sur 24, 7 jours sur 7, des sauvegardes automatiques et des nouvelles fonctionnalités et applications régulièrement mises à jour. Pr', 'logiciels', 0, 650, 650, 200),
(20, 'miniature-medocapp-768x768.jpg', 'Logiciel de Gestion de Cabinet Médical', 'Le logiciel permet une gestion de cabinet médical efficace, fiable, complètement informatisée, organisée et simple grâce à son interface intuitive,\r\n\r\nIl peut convenir à la majorité de spécialité des médecins (généraliste, spécialiste, chirurgien, anesthé', 'logiciels', 0, 2500, 2500, 299),
(21, 'KL11718BCFS-20FFPMAG.jpg', 'Kaspersky Anti-virus 2021 – 3 Postes /1 an', 'Kaspersky Anti-virus 2021 – 3 Postes /1 an (KL11718BCFS-20FFPMAG)', 'logiciels', 5, 250, 237.5, 250),
(22, 'Ordinateur-portable-Asus-D415-8-768x768.png', ' Ordinateur portable Asus D415D ', 'AMD Ryzen™ 3 3250U Mobile Processor (2C/4T, 5MB Cache, 3.5 GHz Max Boost)\r\nRAM: 4GB DDR4 on board\r\nDisque dur: 1TB SATA 5400RPM 2.5″ HDD – 5400 tours/minute\r\nÉcran: 14.0″ HD (1366 x 768) 16:9 aspect ratio LED Backlit 200nits Anti-glare 45% NTSC color gamu', 'ordinateurs_portables', 0, 3420, 3420, 3420),
(23, 'pc-portable-gamer-asus-rog-flow-z13-gz301zc-ld110w-i7-12eme-rtx-3050-ecran-134-fhd-tactile.jpg', 'Ordinateur portable Asus ROG Flow Z13 NR2201 ', '12th Gen Intel® Core™ i7-12700H Processor 2.3 GHz (24M Cache, up to 4.7 GHz, 14 cores: 6 P-cores and 8 E-cores)\r\nRAM: 16 GB (8GB*2 LPDDR5 on board)\r\nDisque dur: 512GB PCIe® 4.0 NVMe™ M.2 SSD (2230)\r\nÉcran: 13.4″ Tactile FHD+ 16:10 (1920 x 1200, WUXGA) 120', 'ordinateurs_portables', 10, 26735, 24061.5, 26735),
(24, 'Nouveau-projet-2024-02-02T122145.495.webp', 'Ordinateur portable HP 15-fd0033nk (898D7EA)', 'Intel® Core™ i5-1335U (jusqu’à 4,6 GHz avec la technologie Intel® Turbo Boost, 12 Mo de mémoire cache L3, 10 cœurs, 12 threads)\r\nRAM: 8 Go de mémoire RAM DDR4-3200 MHz (1 x 8 Go)\r\nDisque dur: SSD PCIe® NVMe™ M.2 512 Go\r\nÉcran: Full HD d’une diagonale de 3', 'ordinateurs_portables', 0, 9410, 9410, 9410),
(25, 'Nouveau-projet-61-768x768.jpg', 'Ordinateur portable HP EliteBook 640 G9 (6Q878ES)', 'Intel® i5-1235U\r\nRAM: 8 Go\r\nDisque dur: 256 Go SSD\r\nÉcran: 14″ de diagonale, HD (1366 x 768), cadre étroit, antireflet, 250 nits, 45 % NTSC\r\nCarte graphique: Intel Iris Xe\r\nWindows 11 Professionnel\r\nClavier: Français (AZERTY)', 'ordinateurs_portables', 0, 12260, 12260, 12260),
(26, 'Nouveau-projet-13-768x768.webp', 'Ordinateur portable HP Omen 16 i7-13620H 16GB 1TSD W11H (845', 'Intel® Core™ i7-13620H (jusqu’à 4.9 GHz avec la technologie Intel® Turbo Boost, 24 Mo de mémoire cache L3, 10 cœurs, 16 threads)\r\nRAM: 16 Go de mémoire RAM DDR5 – 5 200 MHz (2 x 8 Go)\r\nDisque dur: SSD 1 To PCIe® Gen4 NVMe™ TLC M.2\r\nÉcran: Full HD d’une di', 'ordinateurs_portables', 0, 18730, 18730, 18730),
(27, 'Nouveau-projet-2024-02-07T150349.065-768x768.webp', 'Canon PIXMA G3410 Imprimante multifonction ', 'Impression, copie et scan\r\nGI-490 GI-490 GI-490 GI-490\r\nVitesse d’impression noir: 16,4 pages/min (8,8 images/min) en norme ISO\r\nVitesse d’impression couleur: 12,8 pages/min (5 images/min) en norme ISO\r\nQualité d’impression noire: Jusqu’à 4800 × 1200 DPI ', 'imprimantes', 0, 2030, 2030, 2030),
(28, 'Nouveau-projet-2024-02-06T165611.948-768x768.webp', 'Ordinateur de bureau Dell OptiPlex 3000 MT (DL-OP3000-I5-W)', 'Intel Core i5-12500 de 12e génération (6 coeurs/18 Mo/12T/3,0 GHz à 4,6 GHz/65 W)\r\nRAM: 8 Go, 1 x 8 Go, DDR4-SDRAM 3200 Mhz\r\nDisque dur: 512G Disque SSD, M.2 2230, PCIe NVMe,classe 35\r\nCarte graphique: Intel UHD Graphics 770\r\nWindows 10 Professionnel\r\nUni', 'ordinateurs_bureau', 10, 10000, 9000, 100);


DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `profil_user` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `nom_user` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `prenom_user` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `genre_user` varchar(16) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `email_user` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `num_user` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `password_user` varchar(16) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `passwordCn_user` varchar(16) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `daten_user` varchar(16) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `role_user` int NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;


INSERT INTO `users` (`id_user`, `profil_user`, `nom_user`, `prenom_user`, `genre_user`, `email_user`, `num_user`, `password_user`, `passwordCn_user`, `daten_user`, `role_user`, `creation_date`) VALUES
(1, 'profil.jpeg', 'Rihi', 'Rida', 'homme', 'rihirida6@gmail.com', '0777436709', 'Mery2001', 'Mery2001', '2001-06-22', 4, '2024-07-17 23:34:22'),
(2, 'Driss khaddadi.jpg', 'Khaddadi', 'Driss', 'homme', 'Driss.Khaddadi@GMAIL.COM', '', 'Khaddadi.Driss', '', '2004-03-04', 3, '2024-07-17 23:37:32'),
(3, 'ilham.jpg', 'kherrmash', 'ilham', 'homme', 'khermash.ilham@gmail.com', '', 'ilham1234', '', '2001-01-01', 3, '2024-07-17 23:38:22'),
(4, 'mohamed.jpg', 'hemeraoui', 'm\'hamed', 'homme', 'mhamedhemeraoui@gmail.com', '', 'Mery2001', '', '2001-07-09', 3, '2024-07-17 23:42:51'),
(5, 'gogo.jpg', 'client', 'test', 'homme', 'namitest@gmail.com', '', 'sdfhdfjg', '', '2024-07-05', 1, '2024-07-17 23:44:06'),
(6, 'lofi.jpg', 'nabil', 'karim', 'ancun', 'rihirid@gmail.com', '0621883775', 'Mery2001', '', 'ancun', 2, '2024-07-18 22:09:16'),
(7, 'lofi.jpg', 'kawtar', 'kalo', 'femme', 'kawtarkalo@gmail.com', '0777436709', 'mery2001', '', '2024-07-20', 2, '2024-07-19 10:33:06');
COMMIT;
