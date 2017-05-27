-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Creato il: Mag 27, 2017 alle 11:31
-- Versione del server: 10.1.21-MariaDB
-- Versione PHP: 7.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `HomeManager`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `clean_schedule`
--

CREATE TABLE `clean_schedule` (
  `ID` int(11) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  `who` varchar(50) DEFAULT NULL,
  `description` varchar(60) DEFAULT NULL,
  `done` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `clean_schedule`
--

INSERT INTO `clean_schedule` (`ID`, `group_id`, `who`, `description`, `done`) VALUES
(1, 8, '106306279949883', 'pulire la cucina', 0),
(2, 8, '101389887107592', 'bagno', 0),
(3, 8, '10210480900597766', 'piatti', 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `contacts_numbers`
--

CREATE TABLE `contacts_numbers` (
  `ID` int(11) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  `contact_name` varchar(20) DEFAULT NULL,
  `contact_number` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `contacts_numbers`
--

INSERT INTO `contacts_numbers` (`ID`, `group_id`, `contact_name`, `contact_number`) VALUES
(2, 8, 'Davide Belli', '3403720867'),
(3, 8, 'Mamma Pier', '3458329234'),
(4, 8, 'PapÃ  Pier', '3357516196'),
(5, 8, 'Anita', '3458383007'),
(6, 8, 'pippo', '3458383007'),
(7, 8, 'casa', '0376478297');

-- --------------------------------------------------------

--
-- Struttura della tabella `devices`
--

CREATE TABLE `devices` (
  `facebook_id` varchar(100) NOT NULL,
  `firebase_token` text,
  `name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `devices`
--

INSERT INTO `devices` (`facebook_id`, `firebase_token`, `name`) VALUES
('10210480900597766', 'elbLAjG57I4:APA91bEsqkCiJwgck5JqbQfuq91-wMgzAhRdijlUd3fk1meZ2AjJCR5dd0BO6quW_elpIxSUc7myCQqwA4TrSxzmSCakHse8cJQkPsBSsig_FJDdQ61lgynvo5meMkI6RJUvz7cLHjpF', 'Piermaria Arvani'),
('id', 'ramarro', 'peppa pig');

-- --------------------------------------------------------

--
-- Struttura della tabella `groups`
--

CREATE TABLE `groups` (
  `ID` int(11) NOT NULL,
  `facebook_id` varchar(50) DEFAULT NULL,
  `group_name` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `groups`
--

INSERT INTO `groups` (`ID`, `facebook_id`, `group_name`) VALUES
(2, 'id2', 'casarimasta'),
(8, '106306279949883', 'peppapig');

-- --------------------------------------------------------

--
-- Struttura della tabella `group_events`
--

CREATE TABLE `group_events` (
  `ID` int(11) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  `event_date` date DEFAULT NULL,
  `event_hour` time DEFAULT NULL,
  `description` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `group_events`
--

INSERT INTO `group_events` (`ID`, `group_id`, `event_date`, `event_hour`, `description`) VALUES
(4, 8, '2017-05-20', '18:00:00', 'andare a trovare mira'),
(5, 8, '2017-05-21', '20:00:00', 'partenza per trento'),
(6, 8, '2017-05-21', '10:00:00', 'finale torneo ferrari'),
(7, 8, '2017-05-25', '10:00:00', 'finire progetto '),
(8, 8, '2017-05-20', '16:00:00', 'finale juniores'),
(9, 8, '2017-05-22', '13:00:00', 'pranzo con anita'),
(10, 8, '2017-05-22', '18:00:00', 'spesa con D'),
(11, 8, '2017-05-22', '12:00:00', 'preparare referto'),
(12, 8, '2017-05-24', '18:00:00', 'calcetto con cesa'),
(16, 8, '2017-05-22', '22:00:00', 'Andare all\' h '),
(17, 8, '2017-05-25', '11:00:00', 'ritorno a mantova');

-- --------------------------------------------------------

--
-- Struttura della tabella `money`
--

CREATE TABLE `money` (
  `ID` int(11) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  `who` varchar(50) DEFAULT NULL,
  `buy_date` date DEFAULT NULL,
  `element` varchar(50) DEFAULT NULL,
  `cost` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `shopping_list`
--

CREATE TABLE `shopping_list` (
  `ID` int(11) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  `item` varchar(20) DEFAULT NULL,
  `bought` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `shopping_list`
--

INSERT INTO `shopping_list` (`ID`, `group_id`, `item`, `bought`) VALUES
(1, 8, 'pane', 0),
(3, 8, 'piselli', 0),
(4, 8, 'cous cous', 0),
(10, 8, 'carne', 0),
(11, 8, 'pollo', 0),
(12, 8, 'burro', 1),
(13, 8, 'formaggio grana', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `facebook_id` varchar(50) NOT NULL,
  `firebase_token` text,
  `name` varchar(20) DEFAULT NULL,
  `surname` varchar(20) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `debit_credit` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`facebook_id`, `firebase_token`, `name`, `surname`, `group_id`, `debit_credit`) VALUES
('101389887107592', 'ttt', 'Ermenegildo', 'Rossi', 8, 0),
('10210480900597766', 'ej7_HR7svKM:APA91bE34l8y9Hf-NSIGrS5BOGYz1-1Hc3gedtGJPNc8lR8OnV2PyB6elMS_geqTWOkvVu_oRAKgUNvKpibi2qL5DgzL5mGrQ72VYYwYBHN1yogKpuCp8YkvFi3zF--Ag6nM4Q9-an6V', 'Piermaria', 'Arvani', 8, 0),
('106306279949883', 'fUZ95PUIeIA:APA91bGnafaUlsg-0TFMz6RB8U8uWb9xv6vWfT-WPqOe34iTxJBJstTmCzJkHeFqw_cGlZ9dxLLXwwBwL1l92ebcdDhMwm1nv4xREj0cEup7ZZnPlHwXKPjaT1ckUAQxM-S4AERwXB8f', 'Ambrogio', 'Fusella', 8, 0),
('id2', 'tt', 'peppa ', 'pig', 2, 0);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `clean_schedule`
--
ALTER TABLE `clean_schedule`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `who` (`who`),
  ADD KEY `clean_shedule_index` (`group_id`) USING HASH;

--
-- Indici per le tabelle `contacts_numbers`
--
ALTER TABLE `contacts_numbers`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `group_id` (`group_id`);

--
-- Indici per le tabelle `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`facebook_id`);

--
-- Indici per le tabelle `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`ID`);

--
-- Indici per le tabelle `group_events`
--
ALTER TABLE `group_events`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `events_index` (`group_id`,`event_date`) USING BTREE;

--
-- Indici per le tabelle `money`
--
ALTER TABLE `money`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `who` (`who`),
  ADD KEY `money_index` (`group_id`,`buy_date`) USING BTREE;

--
-- Indici per le tabelle `shopping_list`
--
ALTER TABLE `shopping_list`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `shopping_list_index` (`group_id`) USING HASH;

--
-- Indici per le tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`facebook_id`),
  ADD KEY `index_fbid` (`facebook_id`) USING HASH,
  ADD KEY `index_group_id` (`group_id`) USING HASH;

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `clean_schedule`
--
ALTER TABLE `clean_schedule`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT per la tabella `contacts_numbers`
--
ALTER TABLE `contacts_numbers`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT per la tabella `groups`
--
ALTER TABLE `groups`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT per la tabella `group_events`
--
ALTER TABLE `group_events`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT per la tabella `money`
--
ALTER TABLE `money`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `shopping_list`
--
ALTER TABLE `shopping_list`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `clean_schedule`
--
ALTER TABLE `clean_schedule`
  ADD CONSTRAINT `clean_schedule_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`ID`),
  ADD CONSTRAINT `clean_schedule_ibfk_2` FOREIGN KEY (`who`) REFERENCES `users` (`facebook_id`);

--
-- Limiti per la tabella `contacts_numbers`
--
ALTER TABLE `contacts_numbers`
  ADD CONSTRAINT `contacts_numbers_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`ID`);

--
-- Limiti per la tabella `group_events`
--
ALTER TABLE `group_events`
  ADD CONSTRAINT `group_events_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`ID`);

--
-- Limiti per la tabella `money`
--
ALTER TABLE `money`
  ADD CONSTRAINT `money_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`ID`),
  ADD CONSTRAINT `money_ibfk_2` FOREIGN KEY (`who`) REFERENCES `users` (`facebook_id`);

--
-- Limiti per la tabella `shopping_list`
--
ALTER TABLE `shopping_list`
  ADD CONSTRAINT `shopping_list_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`ID`);

--
-- Limiti per la tabella `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
