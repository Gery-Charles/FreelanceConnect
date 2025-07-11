<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250501091759 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE mission_freelance (mission_id INT NOT NULL, freelance_id INT NOT NULL, INDEX IDX_FA1E315CBE6CAE90 (mission_id), INDEX IDX_FA1E315CE8DF656B (freelance_id), PRIMARY KEY(mission_id, freelance_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE mission_freelance ADD CONSTRAINT FK_FA1E315CBE6CAE90 FOREIGN KEY (mission_id) REFERENCES mission (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE mission_freelance ADD CONSTRAINT FK_FA1E315CE8DF656B FOREIGN KEY (freelance_id) REFERENCES utilisateur (id) ON DELETE CASCADE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE mission_freelance DROP FOREIGN KEY FK_FA1E315CBE6CAE90
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE mission_freelance DROP FOREIGN KEY FK_FA1E315CE8DF656B
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE mission_freelance
        SQL);
    }
}
