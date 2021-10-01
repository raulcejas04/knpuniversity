<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211001120758 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE estado_civil_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE nacionalidad_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE persona_fisica_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE persona_juridica_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE representacion_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE sexo_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE usuario_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE estado_civil (id INT NOT NULL, estado_civil VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE nacionalidad (id INT NOT NULL, pais VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE persona_fisica (id INT NOT NULL, sexo_id INT NOT NULL, estado_civil_id INT DEFAULT NULL, nacionalidad_id INT NOT NULL, usuario_id INT DEFAULT NULL, apellido VARCHAR(255) NOT NULL, nombres VARCHAR(255) NOT NULL, nro_doc VARCHAR(255) NOT NULL, cuit_cuil INT NOT NULL, fecha_nac DATE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FA4EDBEA2B32DB58 ON persona_fisica (sexo_id)');
        $this->addSql('CREATE INDEX IDX_FA4EDBEA75376D93 ON persona_fisica (estado_civil_id)');
        $this->addSql('CREATE INDEX IDX_FA4EDBEAAB8DC0F8 ON persona_fisica (nacionalidad_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FA4EDBEADB38439E ON persona_fisica (usuario_id)');
        $this->addSql('CREATE TABLE persona_juridica (id INT NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE representacion (id INT NOT NULL, persona_fisica_id INT NOT NULL, persona_juridica_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E41B26B8319CE0FF ON representacion (persona_fisica_id)');
        $this->addSql('CREATE INDEX IDX_E41B26B8C4B65DE ON representacion (persona_juridica_id)');
        $this->addSql('CREATE TABLE sexo (id INT NOT NULL, sexo VARCHAR(255) NOT NULL, descripcion VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE usuario (id INT NOT NULL, keycloak_id VARCHAR(500) NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2265B05D491914B1 ON usuario (keycloak_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2265B05DE7927C74 ON usuario (email)');
        $this->addSql('ALTER TABLE persona_fisica ADD CONSTRAINT FK_FA4EDBEA2B32DB58 FOREIGN KEY (sexo_id) REFERENCES sexo (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE persona_fisica ADD CONSTRAINT FK_FA4EDBEA75376D93 FOREIGN KEY (estado_civil_id) REFERENCES estado_civil (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE persona_fisica ADD CONSTRAINT FK_FA4EDBEAAB8DC0F8 FOREIGN KEY (nacionalidad_id) REFERENCES nacionalidad (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE persona_fisica ADD CONSTRAINT FK_FA4EDBEADB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE representacion ADD CONSTRAINT FK_E41B26B8319CE0FF FOREIGN KEY (persona_fisica_id) REFERENCES persona_fisica (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE representacion ADD CONSTRAINT FK_E41B26B8C4B65DE FOREIGN KEY (persona_juridica_id) REFERENCES persona_juridica (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE persona_fisica DROP CONSTRAINT FK_FA4EDBEA75376D93');
        $this->addSql('ALTER TABLE persona_fisica DROP CONSTRAINT FK_FA4EDBEAAB8DC0F8');
        $this->addSql('ALTER TABLE representacion DROP CONSTRAINT FK_E41B26B8319CE0FF');
        $this->addSql('ALTER TABLE representacion DROP CONSTRAINT FK_E41B26B8C4B65DE');
        $this->addSql('ALTER TABLE persona_fisica DROP CONSTRAINT FK_FA4EDBEA2B32DB58');
        $this->addSql('ALTER TABLE persona_fisica DROP CONSTRAINT FK_FA4EDBEADB38439E');
        $this->addSql('DROP SEQUENCE estado_civil_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE nacionalidad_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE persona_fisica_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE persona_juridica_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE representacion_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE sexo_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE usuario_id_seq CASCADE');
        $this->addSql('DROP TABLE estado_civil');
        $this->addSql('DROP TABLE nacionalidad');
        $this->addSql('DROP TABLE persona_fisica');
        $this->addSql('DROP TABLE persona_juridica');
        $this->addSql('DROP TABLE representacion');
        $this->addSql('DROP TABLE sexo');
        $this->addSql('DROP TABLE usuario');
    }
}
