<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241020125731 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE customers (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE moderators (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE owners (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE restaurants ADD owner_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE restaurants ADD CONSTRAINT FK_AD8377247E3C61F9 FOREIGN KEY (owner_id) REFERENCES owners (id)');
        $this->addSql('CREATE INDEX IDX_AD8377247E3C61F9 ON restaurants (owner_id)');
        $this->addSql('ALTER TABLE reviews ADD customer_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reviews ADD CONSTRAINT FK_6970EB0F9395C3F3 FOREIGN KEY (customer_id) REFERENCES customers (id)');
        $this->addSql('CREATE INDEX IDX_6970EB0F9395C3F3 ON reviews (customer_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reviews DROP FOREIGN KEY FK_6970EB0F9395C3F3');
        $this->addSql('ALTER TABLE restaurants DROP FOREIGN KEY FK_AD8377247E3C61F9');
        $this->addSql('DROP TABLE customers');
        $this->addSql('DROP TABLE moderators');
        $this->addSql('DROP TABLE owners');
        $this->addSql('DROP INDEX IDX_AD8377247E3C61F9 ON restaurants');
        $this->addSql('ALTER TABLE restaurants DROP owner_id');
        $this->addSql('DROP INDEX IDX_6970EB0F9395C3F3 ON reviews');
        $this->addSql('ALTER TABLE reviews DROP customer_id');
    }
}
