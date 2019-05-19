INSERT INTO `user` (`user_id`, `username`, `disp_name`, `password`) VALUES
(1, 'jDoe', 'John Doe', '1111'),
(2, 'aSmith', 'Adam Smith', '1112'),
(3, 'sKo', 'Sarah Ko', '1113');

INSERT INTO `resource_provider` (`provider_id`, `username`, `street_number`, `street`, `apt_number`, `city`, `state`, `zip`) VALUES
(1, 'aSmith', 1570, 'East Colorado Blvd.', NULL, 'Pasadena', 'CA', 91106),
(2, 'jDoe', 100, 'Los Angeles Blvd.', '22a', 'Los Angeles', 'CA', 90013),
(3, 'sKo', 400, 'West 2nd Street', NULL, 'Los Angeles', 'CA', 90014);

INSERT INTO `cert_member` (`member_id`, `username`, `phone_number`) VALUES
(1, 'aSmith', 2147483641),
(2, 'jDoe', 2147483642),
(3, 'sKo', 2147483643);

INSERT INTO `admin` (`admin_id`, `username`, `email`) VALUES
(1, 'aSmith', 'asmith@pasadena.edu'),
(2, 'jDoe', 'jdoe@pasadena.edu'),
(3, 'sKo', 'sko@pasadena.edu');