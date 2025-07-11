<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250515164612 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE conversation (id INT AUTO_INCREMENT NOT NULL, participant_a_id INT NOT NULL, participant_b_id INT NOT NULL, INDEX IDX_8A8E26E9EF6A4166 (participant_a_id), INDEX IDX_8A8E26E9FDDFEE88 (participant_b_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE conversation ADD CONSTRAINT FK_8A8E26E9EF6A4166 FOREIGN KEY (participant_a_id) REFERENCES utilisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE conversation ADD CONSTRAINT FK_8A8E26E9FDDFEE88 FOREIGN KEY (participant_b_id) REFERENCES utilisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE message ADD conversation_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE message ADD CONSTRAINT FK_B6BD307F9AC0396 FOREIGN KEY (conversation_id) REFERENCES conversation (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_B6BD307F9AC0396 ON message (conversation_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F9AC0396
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE conversation DROP FOREIGN KEY FK_8A8E26E9EF6A4166
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE conversation DROP FOREIGN KEY FK_8A8E26E9FDDFEE88
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE conversation
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_B6BD307F9AC0396 ON message
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE message DROP conversation_id
        SQL);
    }
}
