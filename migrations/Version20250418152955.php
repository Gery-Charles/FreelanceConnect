<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250418152955 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP TABLE client
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE freelance
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE mission ADD client_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE mission ADD CONSTRAINT FK_9067F23C19EB6921 FOREIGN KEY (client_id) REFERENCES utilisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_9067F23C19EB6921 ON mission (client_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE utilisateur ADD type VARCHAR(255) NOT NULL, ADD nom VARCHAR(255) DEFAULT NULL, ADD prenom VARCHAR(255) DEFAULT NULL, ADD competances LONGTEXT DEFAULT NULL COMMENT '(DC2Type:array)'
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE freelance (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, prenom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, competances LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT '(DC2Type:array)', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE mission DROP FOREIGN KEY FK_9067F23C19EB6921
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_9067F23C19EB6921 ON mission
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE mission DROP client_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE utilisateur DROP type, DROP nom, DROP prenom, DROP competances
        SQL);
    }
}
