-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 29 Ara 2021, 14:31:17
-- Sunucu sürümü: 10.4.21-MariaDB
-- PHP Sürümü: 7.4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `arizabildirimi`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `arizadurum`
--

CREATE TABLE `arizadurum` (
  `ID` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_turkish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `arizadurum`
--

INSERT INTO `arizadurum` (`ID`, `name`) VALUES
(1, 'Devam Ediyor'),
(2, 'Tamamlandı'),
(5, 'İşleme Alındı');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `arizalar`
--

CREATE TABLE `arizalar` (
  `ID` int(11) NOT NULL,
  `kod` varchar(25) COLLATE utf8_turkish_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `arizatip_id` int(11) DEFAULT NULL,
  `durum` int(11) NOT NULL,
  `detay` text COLLATE utf8_turkish_ci DEFAULT NULL,
  `create_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `arizalar`
--

INSERT INTO `arizalar` (`ID`, `kod`, `user_id`, `arizatip_id`, `durum`, `detay`, `create_date`) VALUES
(1, '#2525', 1, 1, 2, 'Mikrafon Arızası Var.', '2021-01-15 18:31:43'),
(2, '#2526', 2, 3, 1, 'Şarj Yeri Arızası Var.', '2021-05-15 18:32:00'),
(3, '1621093573-gQzO', 3, 4, 5, 'Ekran Arızası Var.', '2021-05-15 18:46:13'),
(4, '20210515175139-Ksrg', 4, 2, 1, 'Hapörlör Arızası Var.', '2021-05-15 18:51:39'),
(5, '202105', 4, 3, 2, 'AAAA Hapörlör Arızası Var.', '2021-05-15 18:51:39'),
(6, '20210605151323-jkZx', 1, 1, 2, 'aaaa', '2021-06-05 15:13:23');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `arizatip`
--

CREATE TABLE `arizatip` (
  `ID` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_turkish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `arizatip`
--

INSERT INTO `arizatip` (`ID`, `name`) VALUES
(1, 'Mikrafon Arızası'),
(2, 'Hapörlör Arızası'),
(3, 'Şarj Yeri Arızası'),
(4, 'Ekran Arızası');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `mailonay`
--

CREATE TABLE `mailonay` (
  `ID` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `randomcode` varchar(64) COLLATE utf8_turkish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `mailonay`
--

INSERT INTO `mailonay` (`ID`, `user_id`, `randomcode`) VALUES
(1, 8, 'SrRFPwMSAJQKfmLHsWWopuypoXDphvzPavFNFtQWYsrYkKFQsj'),
(2, 9, 'nkixJRtvBgrrtxUnNWKFncUkWHusKtsNViHEPDezJJxeXQpMFQ'),
(3, 10, 'ZurCiubyhvxyogTqbTEEfhYpdJEWFhiGZzLPnggJQGZWWeYHmz');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `sifremiunuttum`
--

CREATE TABLE `sifremiunuttum` (
  `ID` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `randomcode` varchar(64) COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `sifremiunuttum`
--

INSERT INTO `sifremiunuttum` (`ID`, `user_id`, `randomcode`) VALUES
(1, 8, 'mxZHhqLppjzAtUbXYvuiUGLWFpBSCLhbKNPNJqwOtfcahjFZvhAHufEdcywHoWev'),
(2, 11, 'pKwMxctbzbzExQLeaDyTaTRnqxuuJCYseEHmexxtBRHriPxkiTADohUirUawPMQP'),
(3, 11, 'FMZEJjAvwKUoLMwMGdcwmsQPNNpSvWOMYinTjEgrTMKcKenOqhwpJjVfhrLiJVtD'),
(4, 11, 'MpyfpTUTdmwkrmVWoYyNFpGHMakyryWfMPvSJeocNFyoKCMTXSYMDfwNxmnpVZip');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `surname` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `mail` varchar(75) COLLATE utf8_turkish_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `mailonay` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `address` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `phone` varchar(15) COLLATE utf8_turkish_ci NOT NULL,
  `create_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`ID`, `username`, `surname`, `mail`, `password`, `mailonay`, `status`, `address`, `phone`, `create_date`) VALUES
(2, 'Ramazan', 'ŞEN', 'ramazansen.tr@gmail.com', '', 0, 1, '', '0538-691-0921', '2021-05-15 18:11:16'),
(4, 'Orhan', 'IŞIL', 'alahattin3434@hotmail.com', '', 0, 1, '', '0(555)-368-7209', '2021-05-15 18:31:08'),
(8, 'Furkan', 'Bol', 'osmannyldz7878@gmail.com', '$2y$10$83b2vaW42wdxLM3/3kAni.qZcuaJd0/CP8Dx0CYKUiKpxVHMnuxyW', 1, 1, '', '0(530)-158-5544', '2021-07-01 21:16:55'),
(11, 'osman', 'YILDIZ', 'osmann_yldz7878@hotmail.com', '$2y$10$ggd6PDNIsn9gfIxXrQHZhe1tBu0xImj1xtUieDPmlzKvvQMSP.1sW', 1, 1, '', '0(530)-158-5544', '2021-07-01 22:10:30');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `arizadurum`
--
ALTER TABLE `arizadurum`
  ADD PRIMARY KEY (`ID`);

--
-- Tablo için indeksler `arizalar`
--
ALTER TABLE `arizalar`
  ADD PRIMARY KEY (`ID`);

--
-- Tablo için indeksler `arizatip`
--
ALTER TABLE `arizatip`
  ADD PRIMARY KEY (`ID`);

--
-- Tablo için indeksler `mailonay`
--
ALTER TABLE `mailonay`
  ADD PRIMARY KEY (`ID`);

--
-- Tablo için indeksler `sifremiunuttum`
--
ALTER TABLE `sifremiunuttum`
  ADD PRIMARY KEY (`ID`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `arizadurum`
--
ALTER TABLE `arizadurum`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `arizalar`
--
ALTER TABLE `arizalar`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tablo için AUTO_INCREMENT değeri `arizatip`
--
ALTER TABLE `arizatip`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `mailonay`
--
ALTER TABLE `mailonay`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `sifremiunuttum`
--
ALTER TABLE `sifremiunuttum`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
