DROP TABLE IF EXISTS reward_card;
CREATE TABLE IF NOT EXISTS reward_card
(
	reward_card_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	cs_user_id INT UNSIGNED,
	member_id INT UNSIGNED,
	reward_card_code VARCHAR(12) NOT NULL,
	star_amount INT UNSIGNED NOT NULL,
	generated_at DATETIME NOT NULL,
	redeemed_at DATETIME,
	PRIMARY KEY(reward_card_id),
	KEY(cs_user_id),
	KEY(member_id),
	UNIQUE KEY(reward_card_code)
);