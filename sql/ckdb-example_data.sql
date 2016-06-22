--
-- Add example data
--

USE ckdb;

INSERT INTO `users` (`uid`, `email`, `passhash`, `regdate`, `verifykey`) VALUES
(0, 'admin@freezurbern.com', '0', '2016-02-08 00:00:00', '000');

INSERT INTO `foods` (`fid`, `fname`, `fgroup`, `addby`) VALUES
(0, 'None', 'None', 0),
(1, 'Pizza', 'Oil', 0),
(2, 'Pepperoni', 'Oil', 0),
(3, 'Milk Shake', 'Dairy', 0),
(4, 'French Fries', 'Oil', 0),
(5, 'Toast', 'Grain', 0),
(6, 'Garlic Bread', 'Grain', 0),
(7, 'Apple Juice', 'Fruit', 0),
(8, 'Water', 'Liquid', 0),
(9, 'CocaCola', 'Soda', 0),
(10, 'Mtn Dew', 'Soda', 0),
(14, 'Pasta Sauce', 'Oil', 0);