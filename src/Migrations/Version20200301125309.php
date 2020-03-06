<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200301125309 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE card_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE deck_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE params_repeat_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE record_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE flash_user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE refresh_tokens_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE card (id INT NOT NULL, deck_id INT NOT NULL, name VARCHAR(255) NOT NULL, date_next_repeat TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, date_created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, date_last_modified TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, difficulty_index INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_161498D3111948DC ON card (deck_id)');
        $this->addSql('CREATE TABLE deck (id INT NOT NULL, user_id INT NOT NULL, params_repeat_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, limit_repeat INT DEFAULT NULL, limit_learning INT NOT NULL, extra_learning INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_4FAC3637A76ED395 ON deck (user_id)');
        $this->addSql('CREATE INDEX IDX_4FAC3637A25EE8FF ON deck (params_repeat_id)');
        $this->addSql('CREATE TABLE params_repeat (id INT NOT NULL, base INT NOT NULL, modifier INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE record (id INT NOT NULL, card_id INT NOT NULL, value JSON NOT NULL, hint JSON DEFAULT NULL, side SMALLINT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9B349F914ACC9A20 ON record (card_id)');
        $this->addSql('CREATE TABLE flash_user (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, is_active BOOLEAN NOT NULL, confirmation_code VARCHAR(255) DEFAULT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B6D6D81AE7927C74 ON flash_user (email)');
        $this->addSql('CREATE TABLE refresh_tokens (id INT NOT NULL, refresh_token VARCHAR(128) NOT NULL, username VARCHAR(255) NOT NULL, valid TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9BACE7E1C74F2195 ON refresh_tokens (refresh_token)');
        $this->addSql('ALTER TABLE card ADD CONSTRAINT FK_161498D3111948DC FOREIGN KEY (deck_id) REFERENCES deck (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE deck ADD CONSTRAINT FK_4FAC3637A76ED395 FOREIGN KEY (user_id) REFERENCES flash_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE deck ADD CONSTRAINT FK_4FAC3637A25EE8FF FOREIGN KEY (params_repeat_id) REFERENCES params_repeat (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE record ADD CONSTRAINT FK_9B349F914ACC9A20 FOREIGN KEY (card_id) REFERENCES card (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE record DROP CONSTRAINT FK_9B349F914ACC9A20');
        $this->addSql('ALTER TABLE card DROP CONSTRAINT FK_161498D3111948DC');
        $this->addSql('ALTER TABLE deck DROP CONSTRAINT FK_4FAC3637A25EE8FF');
        $this->addSql('ALTER TABLE deck DROP CONSTRAINT FK_4FAC3637A76ED395');
        $this->addSql('DROP SEQUENCE card_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE deck_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE params_repeat_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE record_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE flash_user_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE refresh_tokens_id_seq CASCADE');
        $this->addSql('DROP TABLE card');
        $this->addSql('DROP TABLE deck');
        $this->addSql('DROP TABLE params_repeat');
        $this->addSql('DROP TABLE record');
        $this->addSql('DROP TABLE flash_user');
        $this->addSql('DROP TABLE refresh_tokens');
    }
}
