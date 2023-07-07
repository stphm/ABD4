<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230302163257 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE booking_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE booking_payment_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE booking_ticket_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE booking_ticket_pricing_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE game_room_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE game_room_session_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE reference_booking_payment_status_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE reference_booking_status_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE reference_booking_ticket_pricing_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE reference_game_room_theme_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE reference_people_civility_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE users_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE booking (id INT NOT NULL, id_ref_status INT NOT NULL, payment_id INT DEFAULT NULL, customer_id INT NOT NULL, session_id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E00CEDDEAB938D32 ON booking (id_ref_status)');
        $this->addSql('CREATE INDEX IDX_E00CEDDE4C3A3BB ON booking (payment_id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDE9395C3F3 ON booking (customer_id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDE613FECDF ON booking (session_id)');
        $this->addSql('COMMENT ON COLUMN booking.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN booking.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE booking_payment (id INT NOT NULL, id_ref_payment_status INT NOT NULL, value DOUBLE PRECISION NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, validated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3796C12D908C7D2A ON booking_payment (id_ref_payment_status)');
        $this->addSql('COMMENT ON COLUMN booking_payment.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN booking_payment.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN booking_payment.validated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE booking_ticket (id INT NOT NULL, booking_id INT NOT NULL, reference_pricing_id INT NOT NULL, owner_id INT DEFAULT NULL, id_ref_owner_civility INT DEFAULT NULL, price DOUBLE PRECISION NOT NULL, owner_first_name VARCHAR(255) NOT NULL, owner_last_name VARCHAR(255) NOT NULL, owner_age INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2C3A965D3301C60 ON booking_ticket (booking_id)');
        $this->addSql('CREATE INDEX IDX_2C3A965DDC7A9A3C ON booking_ticket (reference_pricing_id)');
        $this->addSql('CREATE INDEX IDX_2C3A965D7E3C61F9 ON booking_ticket (owner_id)');
        $this->addSql('CREATE INDEX IDX_2C3A965DE0197DFA ON booking_ticket (id_ref_owner_civility)');
        $this->addSql('CREATE TABLE booking_ticket_pricing (id INT NOT NULL, id_ref_pricing INT NOT NULL, value DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_72520E9139F73214 ON booking_ticket_pricing (id_ref_pricing)');
        $this->addSql('CREATE TABLE game_room (id INT NOT NULL, theme_id INT NOT NULL, duration INT NOT NULL, is_vr BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_998A3DB759027487 ON game_room (theme_id)');
        $this->addSql('CREATE TABLE game_room_session (id INT NOT NULL, id_game_room INT NOT NULL, start_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, end_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D2B65D5A19BF8190 ON game_room_session (id_game_room)');
        $this->addSql('COMMENT ON COLUMN game_room_session.start_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN game_room_session.end_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE reference_booking_payment_status (id INT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE reference_booking_status (id INT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE reference_booking_ticket_pricing (id INT NOT NULL, label VARCHAR(255) NOT NULL, current_value DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE reference_game_room_theme (id INT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE reference_people_civility (id INT NOT NULL, label VARCHAR(20) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE users (id INT NOT NULL, civility_id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, age INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9E7927C74 ON users (email)');
        $this->addSql('CREATE INDEX IDX_1483A5E923D6A298 ON users (civility_id)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDEAB938D32 FOREIGN KEY (id_ref_status) REFERENCES reference_booking_status (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE4C3A3BB FOREIGN KEY (payment_id) REFERENCES booking_payment (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE9395C3F3 FOREIGN KEY (customer_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE613FECDF FOREIGN KEY (session_id) REFERENCES game_room_session (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE booking_payment ADD CONSTRAINT FK_3796C12D908C7D2A FOREIGN KEY (id_ref_payment_status) REFERENCES reference_booking_payment_status (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE booking_ticket ADD CONSTRAINT FK_2C3A965D3301C60 FOREIGN KEY (booking_id) REFERENCES booking (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE booking_ticket ADD CONSTRAINT FK_2C3A965DDC7A9A3C FOREIGN KEY (reference_pricing_id) REFERENCES reference_booking_ticket_pricing (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE booking_ticket ADD CONSTRAINT FK_2C3A965D7E3C61F9 FOREIGN KEY (owner_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE booking_ticket ADD CONSTRAINT FK_2C3A965DE0197DFA FOREIGN KEY (id_ref_owner_civility) REFERENCES reference_people_civility (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE booking_ticket_pricing ADD CONSTRAINT FK_72520E9139F73214 FOREIGN KEY (id_ref_pricing) REFERENCES reference_booking_ticket_pricing (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE game_room ADD CONSTRAINT FK_998A3DB759027487 FOREIGN KEY (theme_id) REFERENCES reference_game_room_theme (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE game_room_session ADD CONSTRAINT FK_D2B65D5A19BF8190 FOREIGN KEY (id_game_room) REFERENCES game_room (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E923D6A298 FOREIGN KEY (civility_id) REFERENCES reference_people_civility (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE booking_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE booking_payment_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE booking_ticket_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE booking_ticket_pricing_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE game_room_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE game_room_session_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE reference_booking_payment_status_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE reference_booking_status_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE reference_booking_ticket_pricing_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE reference_game_room_theme_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE reference_people_civility_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE users_id_seq CASCADE');
        $this->addSql('ALTER TABLE booking DROP CONSTRAINT FK_E00CEDDEAB938D32');
        $this->addSql('ALTER TABLE booking DROP CONSTRAINT FK_E00CEDDE4C3A3BB');
        $this->addSql('ALTER TABLE booking DROP CONSTRAINT FK_E00CEDDE9395C3F3');
        $this->addSql('ALTER TABLE booking DROP CONSTRAINT FK_E00CEDDE613FECDF');
        $this->addSql('ALTER TABLE booking_payment DROP CONSTRAINT FK_3796C12D908C7D2A');
        $this->addSql('ALTER TABLE booking_ticket DROP CONSTRAINT FK_2C3A965D3301C60');
        $this->addSql('ALTER TABLE booking_ticket DROP CONSTRAINT FK_2C3A965DDC7A9A3C');
        $this->addSql('ALTER TABLE booking_ticket DROP CONSTRAINT FK_2C3A965D7E3C61F9');
        $this->addSql('ALTER TABLE booking_ticket DROP CONSTRAINT FK_2C3A965DE0197DFA');
        $this->addSql('ALTER TABLE booking_ticket_pricing DROP CONSTRAINT FK_72520E9139F73214');
        $this->addSql('ALTER TABLE game_room DROP CONSTRAINT FK_998A3DB759027487');
        $this->addSql('ALTER TABLE game_room_session DROP CONSTRAINT FK_D2B65D5A19BF8190');
        $this->addSql('ALTER TABLE users DROP CONSTRAINT FK_1483A5E923D6A298');
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE booking_payment');
        $this->addSql('DROP TABLE booking_ticket');
        $this->addSql('DROP TABLE booking_ticket_pricing');
        $this->addSql('DROP TABLE game_room');
        $this->addSql('DROP TABLE game_room_session');
        $this->addSql('DROP TABLE reference_booking_payment_status');
        $this->addSql('DROP TABLE reference_booking_status');
        $this->addSql('DROP TABLE reference_booking_ticket_pricing');
        $this->addSql('DROP TABLE reference_game_room_theme');
        $this->addSql('DROP TABLE reference_people_civility');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
