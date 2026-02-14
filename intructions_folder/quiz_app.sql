-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 23.01.2025 klo 06:27
-- Palvelimen versio: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quiz_app`
--

-- --------------------------------------------------------

--
-- Rakenne taululle `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `teacher_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vedos taulusta `categories`
--

INSERT INTO `categories` (`id`, `name`, `teacher_id`) VALUES
(1, 'Historia', 1),
(2, 'Maantiede', 1),
(3, 'Urheilu', 1),
(4, 'Tiede', 1),
(5, 'Taide ja viihde', 1),
(6, 'Historia', 2),
(7, 'Maantiede', 2),
(8, 'Urheilu', 2),
(9, 'PHP', 2),
(10, 'Vapaa-aika', 2);

-- --------------------------------------------------------

--
-- Rakenne taululle `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `question` text NOT NULL,
  `option_a` varchar(255) NOT NULL,
  `option_b` varchar(255) NOT NULL,
  `option_c` varchar(255) NOT NULL,
  `option_d` varchar(255) NOT NULL,
  `correct_option` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vedos taulusta `questions`
--

INSERT INTO `questions` (`id`, `category_id`, `teacher_id`, `question`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`) VALUES
(1, 1, 1, 'Kuka oli ensimmäinen Yhdysvaltain presidentti?', 'George Washington', 'Thomas Jefferson', 'Abraham Lincoln', 'John Adams', 'A'),
(2, 1, 1, 'Missä vuonna Titanic upposi Atlantilla?', '1905', '1912', '1921', '1930', 'B'),
(3, 1, 1, 'Kuka hallitsi Ranskaa suuren osan 1800-lukua?', 'Ludvig XIV', 'Napoleon Bonaparte', 'Henrik V', 'Charles de Gaulle', 'B'),
(4, 1, 1, 'Kuka oli Neuvostoliiton ensimmäinen johtaja?', 'Vladimir Lenin', 'Josif Stalin', 'Leonid Brežnev', 'Nikita Hruštšov', 'A'),
(5, 1, 1, 'Missä vuonna Berliinin muuri murtui?', '1987', '1989', '1991', '1993', 'B'),
(6, 1, 1, 'Kuka oli Englannin kuningatar, joka hallitsi viktoriaanisella ajalla?', 'Kuningatar Viktoria', 'Kuningatar Elisabet I', 'Kuningatar Mary', 'Kuningatar Anne', 'A'),
(7, 1, 1, 'Missä sodassa käytiin kuuluisa Normandian maihinnousu?', 'Ensimmäinen maailmansota', 'Toinen maailmansota', 'Korean sota', 'Vietnamin sota', 'B'),
(8, 1, 1, 'Kuka oli viimeinen farao muinaisessa Egyptissä?', 'Tutankhamon', 'Ramses II', 'Cleopatra', 'Akhenaten', 'C'),
(9, 1, 1, 'Mikä oli ensimmäisen maailmansodan pääasiallinen syy?', 'Saksan ja Ranskan välinen konflikti', 'Assassinaatio Sarajevossa', 'Britannian ja Saksan kilpailu', 'Venäjän vallankumous', 'B'),
(10, 1, 1, 'Missä maassa alkoi teollinen vallankumous?', 'Yhdysvallat', 'Ranska', 'Britannia', 'Saksa', 'C'),
(11, 2, 1, 'Mikä on maailman suurin valtameri?', 'Atlantin valtameri', 'Tyynimeri', 'Intian valtameri', 'Jäämeri', 'B'),
(12, 2, 1, 'Mikä on maailman suurin aavikko?', 'Sahara', 'Arabian aavikko', 'Gobi', 'Kalahari', 'A'),
(13, 2, 1, 'Missä maassa sijaitsee Amazon-joki?', 'Kolumbia', 'Peru', 'Brasilia', 'Venezuela', 'C'),
(14, 2, 1, 'Mikä on maailman pienin maa pinta-alaltaan?', 'Vatikaanivaltio', 'Monaco', 'San Marino', 'Liechtenstein', 'A'),
(15, 2, 1, 'Mikä on Australian suurin kaupunki?', 'Sydney', 'Melbourne', 'Brisbane', 'Canberra', 'A'),
(16, 2, 1, 'Missä maassa Machu Picchu sijaitsee?', 'Meksiko', 'Peru', 'Chile', 'Kolumbia', 'B'),
(17, 2, 1, 'Mikä valtio omistaa Grönlannin?', 'Islanti', 'Norja', 'Tanska', 'Ruotsi', 'C'),
(18, 2, 1, 'Mikä on Yhdysvaltain pisin joki?', 'Mississippi', 'Missouri', 'Colorado', 'Ohio', 'B'),
(19, 2, 1, 'Mikä on Etelä-Afrikan pääkaupunki?', 'Pretoria', 'Cape Town', 'Johannesburg', 'Durban', 'A'),
(20, 2, 1, 'Missä maassa Eiffel-torni sijaitsee?', 'Espanja', 'Italia', 'Ranska', 'Saksa', 'C'),
(21, 3, 1, 'Kuka on voittanut eniten Grand Slam -turnauksia tenniksessä (miehet)?', 'Roger Federer', 'Rafael Nadal', 'Novak Djokovic', 'Pete Sampras', 'C'),
(22, 3, 1, 'Missä maassa pidettiin ensimmäiset modernit olympialaiset vuonna 1896?', 'Ranska', 'Kreikka', 'Iso-Britannia', 'Italia', 'B'),
(23, 3, 1, 'Mikä maa voitti jalkapallon maailmanmestaruuden vuonna 2018?', 'Brasilia', 'Saksa', 'Argentiina', 'Ranska', 'D'),
(24, 3, 1, 'Kuinka monta pelaajaa on koripallojoukkueessa kentällä kerrallaan?', '5', '6', '7', '8', 'A'),
(25, 3, 1, 'Kuka on tunnettu \"Jäämies\" F1-kuljettajana?', 'Michael Schumacher', 'Lewis Hamilton', 'Kimi Räikkönen', 'Sebastian Vettel', 'C'),
(26, 3, 1, 'Kuinka monta kultamitalia Michael Phelps voitti Pekingin olympialaisissa 2008?', '6', '7', '8', '9', 'C'),
(27, 3, 1, 'Kuka voitti ensimmäisen Tour de Francen?', 'Maurice Garin', 'Eddy Merckx', 'Bernard Hinault', 'Lance Armstrong', 'A'),
(28, 3, 1, 'Missä maassa järjestettiin vuoden 2010 jalkapallon MM-kisat?', 'Saksa', 'Etelä-Afrikka', 'Brasilia', 'Venäjä', 'B'),
(29, 3, 1, 'Kuka koripalloilija tunnetaan lempinimellä \"King James\"?', 'Michael Jordan', 'LeBron James', 'Kobe Bryant', 'Shaquille O\'Neal', 'B'),
(30, 3, 1, 'Mikä maa on voittanut eniten kriketin maailmanmestaruuksia?', 'Australia', 'Englanti', 'Intia', 'Pakistan', 'A'),
(31, 4, 1, 'Mikä alkuaine on kemialliselta merkiltään H?', 'Happi', 'Helium', 'Vety', 'Kloori', 'C'),
(32, 4, 1, 'Kuka kehitti yleisen suhteellisuusteorian?', 'Albert Einstein', 'Isaac Newton', 'Niels Bohr', 'Galileo Galilei', 'A'),
(33, 4, 1, 'Mikä on ihmiskehon suurin elin?', 'Aivot', 'Iho', 'Maksa', 'Sydän', 'B'),
(34, 4, 1, 'Mikä planeetta tunnetaan punaisena planeettana?', 'Venus', 'Mars', 'Jupiter', 'Saturnus', 'B'),
(35, 4, 1, 'Mikä on veden kemiallinen kaava?', 'H2', 'O2', 'CO2', 'H2O', 'D'),
(36, 4, 1, 'Mikä yksikkö on voiman SI-yksikkö?', 'Joule', 'Watti', 'Newton', 'Ohmi', 'C'),
(37, 4, 1, 'Kuka on DNA:n kaksoiskierremallin löytäjä yhdessä James Watsonin kanssa?', 'Rosalind Franklin', 'Francis Crick', 'Erwin Schrödinger', 'Linus Pauling', 'B'),
(38, 4, 1, 'Mikä eläin on nisäkästen joukossa ainutlaatuinen munimisensa vuoksi?', 'Nokkonokkaeläin', 'Piikkisika', 'Vyötiäinen', 'Koala', 'A'),
(39, 4, 1, 'Mikä on valon nopeus tyhjiössä?', '300,000 km/s', '150,000 km/s', '500,000 km/s', '1,000,000 km/s', 'A'),
(40, 4, 1, 'Kuka tunnetaan evoluutioteorian isänä?', 'Charles Darwin', 'Gregor Mendel', 'James Watson', 'Louis Pasteur', 'A'),
(41, 5, 1, 'Kuka ohjasi elokuvan \"Titanic\"?', 'Steven Spielberg', 'Martin Scorsese', 'James Cameron', 'George Lucas', 'C'),
(42, 5, 1, 'Mikä yhtye levytti kappaleen \"Hey Jude\"?', 'The Beatles', 'The Rolling Stones', 'The Who', 'Led Zeppelin', 'A'),
(43, 5, 1, 'Kuka näytteli pääroolin elokuvassa \"Forrest Gump\"?', 'Tom Hanks', 'Leonardo DiCaprio', 'Matt Damon', 'Brad Pitt', 'A'),
(44, 5, 1, 'Kuka sävelsi teoksen \"Eine kleine Nachtmusik\"?', 'Ludwig van Beethoven', 'Wolfgang Amadeus Mozart', 'Johann Sebastian Bach', 'Franz Schubert', 'B'),
(45, 5, 1, 'Mikä maalaus tunnetaan nimellä \"Mona Lisa\"?', 'The Scream', 'Starry Night', 'The Persistence of Memory', 'Mona Lisa', 'D'),
(46, 5, 1, 'Kuka on Harry Potter -kirjasarjan kirjoittaja?', 'J.K. Rowling', 'J.R.R. Tolkien', 'C.S. Lewis', 'George R.R. Martin', 'A'),
(47, 5, 1, 'Kuka tunnetaan maalaustaiteen \"Kuutamosonaatti\" säveltäjänä?', 'Frédéric Chopin', 'Johann Sebastian Bach', 'Ludwig van Beethoven', 'Wolfgang Amadeus Mozart', 'C'),
(48, 5, 1, 'Mikä elokuva voitti parhaan elokuvan Oscarin vuonna 2020?', '1917', 'Joker', 'Parasite', 'Once Upon a Time in Hollywood', 'C'),
(49, 5, 1, 'Kuka näytteli Iron Mania Marvelin elokuvasarjassa?', 'Robert Downey Jr.', 'Chris Evans', 'Chris Hemsworth', 'Mark Ruffalo', 'A'),
(50, 5, 1, 'Kuka on laulanut kappaleen \"Thriller\"?', 'Michael Jackson', 'Prince', 'Elton John', 'Stevie Wonder', 'A'),
(51, 6, 2, 'Missä kaupungissa Julius Caesar murhattiin?', 'Ateena', 'Rooma', 'Kartago', 'Aleksandria', 'B'),
(52, 6, 2, 'Kuka oli Ranskan viimeinen kuningas ennen Ranskan vallankumousta?', 'Ludvig XIV', 'Ludvig XV', 'Ludvig XVI', 'Napoleon', 'C'),
(53, 6, 2, 'Kuka oli tunnettu kuningatar Englannissa 1500-luvulla?', 'Elisabet I', 'Maria I', 'Viktoria', 'Anna', 'A'),
(54, 6, 2, 'Kuka johti Neuvostoliittoa toisen maailmansodan aikana?', 'Lenin', 'Trotski', 'Stalin', 'Hruštšov', 'C'),
(55, 6, 2, 'Mikä valtio hyökkäsi Puolaan vuonna 1939 aloittaen toisen maailmansodan?', 'Italia', 'Japani', 'Saksa', 'Neuvostoliitto', 'C'),
(56, 6, 2, 'Missä maassa tapahtui Teekutsujen kapina vuonna 1773?', 'Kanada', 'Yhdysvallat', 'Iso-Britannia', 'Ranska', 'B'),
(57, 6, 2, 'Kuka oli kuuluisa Kreikan sodan jumala?', 'Zeus', 'Apollo', 'Ares', 'Hermes', 'C'),
(58, 6, 2, 'Kuka oli kuuluisin farao muinaisessa Egyptissä?', 'Cleopatra', 'Tutankhamon', 'Ramses II', 'Akhenaten', 'B'),
(59, 6, 2, 'Kuka perusti Mongolivaltakunnan?', 'Kublai-kaani', 'Tamerlane', 'Genghis-kaani', 'Attila', 'C'),
(60, 6, 2, 'Missä vuosisadalla Yhdysvallat itsenäistyi?', '1600-luku', '1700-luku', '1800-luku', '1900-luku', 'B'),
(61, 6, 2, 'Kuka oli ensimmäinen Britannian kuningatar, joka hallitsi omissa nimissään?', 'Mary I', 'Elizabeth I', 'Victoria', 'Anne', 'A'),
(62, 6, 2, 'Missä kaupungissa perustettiin Yhdistyneet kansakunnat?', 'Washington D.C.', 'New York', 'San Francisco', 'Lontoo', 'C'),
(63, 6, 2, 'Mikä valtakunta tunnettiin nimellä \"Rooman vihollinen\"?', 'Egypti', 'Persia', 'Karthago', 'Kreikka', 'C'),
(64, 6, 2, 'Missä vuonna Bastilji valloitettiin Ranskan vallankumouksessa?', '1789', '1792', '1804', '1815', 'A'),
(65, 6, 2, 'Kuka oli kuuluisa matemaatikko ja fyysikko, joka keksi painovoiman?', 'Albert Einstein', 'Isaac Newton', 'Galileo Galilei', 'Nikola Tesla', 'B'),
(66, 6, 2, 'Missä vuonna Napoleon hävisi Waterloon taistelun?', '1805', '1812', '1815', '1821', 'C'),
(67, 6, 2, 'Mikä maa oli osa Kolmivaltaliittoa toisen maailmansodan aikana?', 'Ranska', 'Italia', 'Yhdysvallat', 'Kiina', 'B'),
(68, 6, 2, 'Missä vuonna avaruusajan katsotaan alkaneen Sputnikin laukaisulla?', '1953', '1957', '1961', '1969', 'B'),
(69, 6, 2, 'Mikä Egyptin faarao tunnetaan parhaiten hautakammionsa aarteista?', 'Cleopatra', 'Tutankhamon', 'Ramses II', 'Akhenaten', 'B'),
(70, 6, 2, 'Kuka oli Rooman valtakunnan ensimmäinen keisari?', 'Julius Caesar', 'Augustus', 'Nero', 'Caligula', 'B'),
(71, 7, 2, 'Missä maassa on eniten saaristoa?', 'Kanada', 'Norja', 'Filippiinit', 'Indonesia', 'A'),
(72, 7, 2, 'Mikä joki on pisin Etelä-Amerikassa?', 'Niili', 'Mississippi', 'Amazon', 'Mekong', 'C'),
(73, 7, 2, 'Mikä valtio on maailman tiheimmin asuttu?', 'Intia', 'Bangladesh', 'Kiina', 'Monaco', 'D'),
(74, 7, 2, 'Mikä on Euroopan pisin joki?', 'Tajo', 'Tonava', 'Volga', 'Elbe', 'C'),
(75, 7, 2, 'Mikä vuori on korkein Afrikassa?', 'Kilimanjaro', 'Everest', 'Elbrus', 'Aconcagua', 'A'),
(76, 7, 2, 'Mikä meri sijaitsee Italian länsipuolella?', 'Välimeri', 'Adrianmeri', 'Ionianmeri', 'Tyrrhenanmeri', 'D'),
(77, 7, 2, 'Missä maassa on eniten järviä maailmassa?', 'Suomi', 'Venäjä', 'Kanada', 'Yhdysvallat', 'C'),
(78, 7, 2, 'Mikä on Aasian suurin saari?', 'Sri Lanka', 'Sumatra', 'Honshu', 'Borneo', 'D'),
(79, 7, 2, 'Mikä on Australian pisin joki?', 'Murray', 'Darling', 'Swan', 'Lachlan', 'A'),
(80, 7, 2, 'Mikä on Islannin pääkaupunki?', 'Helsinki', 'Oslo', 'Reykjavik', 'Tukholma', 'C'),
(81, 7, 2, 'Mikä on maailman syvin järvi?', 'Baikal', 'Tanganjika', 'Kaspianmeri', 'Victoria', 'A'),
(82, 7, 2, 'Missä valtiossa sijaitsee Gizan suuri pyramidi?', 'Israel', 'Egypti', 'Jordania', 'Libanon', 'B'),
(83, 7, 2, 'Mikä on suurin valtio pinta-alaltaan?', 'Yhdysvallat', 'Kiina', 'Venäjä', 'Kanada', 'C'),
(84, 7, 2, 'Missä maassa on Machu Picchu?', 'Chile', 'Peru', 'Bolivia', 'Argentiina', 'B'),
(85, 7, 2, 'Mikä joki virtaa Pariisin läpi?', 'Rein', 'Seine', 'Tajo', 'Rhone', 'B'),
(86, 7, 2, 'Mikä valtameri ympäröi Japania?', 'Atlantti', 'Intian valtameri', 'Tyynimeri', 'Jäämeri', 'C'),
(87, 7, 2, 'Mikä on Yhdysvaltain pääkaupunki?', 'New York', 'Los Angeles', 'Washington D.C.', 'Chicago', 'C'),
(88, 7, 2, 'Mikä on maailman korkein vesiputous?', 'Iguazu-putoukset', 'Niagara-putoukset', 'Victoria-putoukset', 'Angel-putoukset', 'D'),
(89, 7, 2, 'Mikä maa on kuuluisa tulivuorestaan Fuji?', 'Kiina', 'Etelä-Korea', 'Japani', 'Thaimaa', 'C'),
(90, 7, 2, 'Mikä meri sijaitsee Saudi-Arabian länsipuolella?', 'Punainen meri', 'Välimeri', 'Persianlahti', 'Kaspianmeri', 'A'),
(91, 7, 2, 'Mikä valtio tunnetaan nimellä \"nousevan auringon maa\"?', 'Kiina', 'Etelä-Korea', 'Japani', 'Thaimaa', 'C'),
(92, 7, 2, 'Mikä on maailman kolmanneksi suurin valtameri?', 'Intian valtameri', 'Tyynimeri', 'Atlantti', 'Jäämeri', 'A'),
(93, 7, 2, 'Missä maassa sijaitsee Iguazu-putoukset?', 'Peru', 'Argentiina', 'Brasilia', 'Chile', 'C'),
(94, 7, 2, 'Mikä on Kreikan pääkaupunki?', 'Ateena', 'Rooma', 'Sofia', 'Istanbul', 'A'),
(95, 7, 2, 'Mikä joki virtaa Lontoon läpi?', 'Seine', 'Rhone', 'Thames', 'Elbe', 'C'),
(96, 7, 2, 'Mikä vuoristo sijaitsee Euroopan ja Aasian rajalla?', 'Kalliovuoret', 'Andit', 'Himalaja', 'Uralvuoret', 'D'),
(97, 7, 2, 'Mikä maa tunnetaan nimellä tulimainen maa?', 'Chile', 'Argentiina', 'Peru', 'Bolivia', 'A'),
(98, 7, 2, 'Mikä on maailman suurin trooppinen sademetsä?', 'Kongo', 'Amazon', 'Sundarbans', 'Valdivian sademetsä', 'B'),
(99, 7, 2, 'Mikä on maailman korkein saari?', 'Malesia', 'Sumatra', 'Borneo', 'Uusi-Guinea', 'D'),
(100, 7, 2, 'Mikä valtio omistaa suurimman osan Himalajaa?', 'Nepal', 'Bhutan', 'Intia', 'Kiina', 'C');

-- --------------------------------------------------------

--
-- Rakenne taululle `teachers`
--

CREATE TABLE `teachers` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vedos taulusta `teachers`
--

INSERT INTO `teachers` (`id`, `username`, `password_hash`) VALUES
(1, 'Oulevi Opettaja', 'Salasana'),
(2, 'Jyri Lindroos', '$2y$10$bRtqNYay./ZXjimcgaIcQetpPBKOJQpY9QGQj3BlemRGH5sGT4QEu');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Rajoitteet vedostauluille
--

--
-- Rajoitteet taululle `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`);

--
-- Rajoitteet taululle `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `questions_ibfk_2` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
