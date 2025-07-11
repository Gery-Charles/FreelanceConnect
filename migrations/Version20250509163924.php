<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250509163924 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, emetteur_id INT NOT NULL, contenu LONGTEXT NOT NULL, date_envoi DATETIME NOT NULL, INDEX IDX_B6BD307F79E92E8C (emetteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE message_utilisateur (message_id INT NOT NULL, utilisateur_id INT NOT NULL, INDEX IDX_7D633D4A537A1329 (message_id), INDEX IDX_7D633D4AFB88E14F (utilisateur_id), PRIMARY KEY(message_id, utilisateur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE message ADD CONSTRAINT FK_B6BD307F79E92E8C FOREIGN KEY (emetteur_id) REFERENCES utilisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE message_utilisateur ADD CONSTRAINT FK_7D633D4A537A1329 FOREIGN KEY (message_id) REFERENCES message (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE message_utilisateur ADD CONSTRAINT FK_7D633D4AFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F79E92E8C
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE message_utilisateur DROP FOREIGN KEY FK_7D633D4A537A1329
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE message_utilisateur DROP FOREIGN KEY FK_7D633D4AFB88E14F
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE message
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE message_utilisateur
        SQL);
    }
}
