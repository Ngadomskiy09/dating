Create Table member
(
    member_id int NOT NULL AUTO_INCREMENT,
    member_fname VARCHAR(255) NOT NULL,
    member_lname VARCHAR(255) NOT NULL,
    member_age int(3) NOT NULL,
    member_gender CHAR(1),
    member_phone VARCHAR (20) NOT NULL,
    member_email VARCHAR(255) NOT NULL,
    member_state CHAR(2),
    member_seeking CHAR(1),
    member_bio VARCHAR(255),
    member_premium TINYINT(1) NOT NULL,

    PRIMARY KEY (member_id)
)

INSERT INTO member VALUES (DEFAULT, "Nick", "Gadomskiy", "30", "M", "2533943445", "ngadomskiy09@gmail.com", "WA", "F", "Just looking", "1")

Create Table interests
(
    interest_id int NOT NULL AUTO_INCREMENT,
    interest VARCHAR(255),
    interest_type CHAR(7),

    PRIMARY KEY (interest_id)
)

CREATE Table member_interest
(
    member_id int NOT NULL,
    interest_id int NOT NULL,

    FOREIGN KEY (member_id) REFERENCES member (member_id), FOREIGN key (interest_id) REFERENCES interests (interest_id)
)