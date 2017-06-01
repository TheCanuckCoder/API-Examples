CREATE TABLE `stv_users` (
  `id` int(10) NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stv_users`
--

INSERT INTO `stv_users` (`id`, `name`, `email`) VALUES
(1, 'Steve', 'steve@site.com'),
(2, 'Dave', 'dave@site.com'),
(3, 'Kathy', 'steve@ottawa-web.ca'),
(4, 'Blaine', 'blaine@ottawa-web.ca'),
(5, 'Debbie', 'debbie@ottawa-web.ca');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `stv_users`
--
ALTER TABLE `stv_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `stv_users`
--
ALTER TABLE `stv_users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;