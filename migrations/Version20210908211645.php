<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210908211645 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user CHANGE keycloak_id keycloak_id VARCHAR(500) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649491914B1 ON user (keycloak_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_8D93D649491914B1 ON user');
        $this->addSql('ALTER TABLE user CHANGE keycloak_id keycloak_id INT NOT NULL');
    }
}
