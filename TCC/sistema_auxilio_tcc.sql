/* modelofisico: */

CREATE TABLE areas (
    id smallint PRIMARY KEY,
    nome varchar(60),
    descricao varchar(100)
);

CREATE TABLE professores (
    id smallint PRIMARY KEY,
    nome varchar(60),
    matricula varchar(30),
    fk_areas_id smallint
);

CREATE TABLE tema (
    id smallint PRIMARY KEY,
    nome varchar(60),
    descricao varchar(100),
    fk_areas_id smallint
);

CREATE TABLE aluno_tema (
    id smallint PRIMARY KEY,
    fk_tema_id smallint,
    fk_professores_id smallint,
    fk_alunos_id smallint
);

CREATE TABLE alunos (
    id smallint PRIMARY KEY,
    nome varchar(60),
    matricula varchar(30)
);
 
ALTER TABLE professores ADD CONSTRAINT FK_professores_2
    FOREIGN KEY (fk_areas_id)
    REFERENCES areas (id)
    ON DELETE CASCADE;
 
ALTER TABLE tema ADD CONSTRAINT FK_tema_2
    FOREIGN KEY (fk_areas_id)
    REFERENCES areas (id)
    ON DELETE RESTRICT;
 
ALTER TABLE aluno_tema ADD CONSTRAINT FK_aluno_tema_2
    FOREIGN KEY (fk_tema_id)
    REFERENCES tema (id)
    ON DELETE RESTRICT;
 
ALTER TABLE aluno_tema ADD CONSTRAINT FK_aluno_tema_3
    FOREIGN KEY (fk_professores_id)
    REFERENCES professores (id)
    ON DELETE SET NULL;
 
ALTER TABLE aluno_tema ADD CONSTRAINT FK_aluno_tema_4
    FOREIGN KEY (fk_alunos_id)
    REFERENCES alunos (id)
    ON DELETE RESTRICT;/* modelofisico: */

CREATE TABLE areas (
    id smallint AUTO_INCREMENT PRIMARY KEY,
    nome varchar(60),
    descricao varchar(100)
);

CREATE TABLE professores (
    id smallint AUTO_INCREMENT PRIMARY KEY,
    nome varchar(60),
    matricula varchar(30),
    fk_areas_id smallint
);

CREATE TABLE tema (
    id smallint AUTO_INCREMENT PRIMARY KEY,
    nome varchar(60),
    descricao varchar(100),
    fk_areas_id smallint
);

CREATE TABLE aluno_tema (
    id smallint AUTO_INCREMENT PRIMARY KEY,
    fk_tema_id smallint,
    fk_professores_id smallint,
    fk_alunos_id smallint
);

CREATE TABLE alunos (
    id smallint AUTO_INCREMENT PRIMARY KEY,
    nome varchar(60),
    matricula varchar(30)
);
 
ALTER TABLE professores ADD CONSTRAINT FK_professores_2
    FOREIGN KEY (fk_areas_id)
    REFERENCES areas (id)
    ON DELETE CASCADE;
 
ALTER TABLE tema ADD CONSTRAINT FK_tema_2
    FOREIGN KEY (fk_areas_id)
    REFERENCES areas (id)
    ON DELETE RESTRICT;
 
ALTER TABLE aluno_tema ADD CONSTRAINT FK_aluno_tema_2
    FOREIGN KEY (fk_tema_id)
    REFERENCES tema (id)
    ON DELETE RESTRICT;
 
ALTER TABLE aluno_tema ADD CONSTRAINT FK_aluno_tema_3
    FOREIGN KEY (fk_professores_id)
    REFERENCES professores (id)
    ON DELETE SET NULL;
 
ALTER TABLE aluno_tema ADD CONSTRAINT FK_aluno_tema_4
    FOREIGN KEY (fk_alunos_id)
    REFERENCES alunos (id)
    ON DELETE RESTRICT;/* modelofisico: */

CREATE TABLE areas (
    id smallint AUTO_INCREMENT PRIMARY KEY,
    nome varchar(60),
    descricao varchar(100)
);

CREATE TABLE professores (
    id smallint  AUTO_INCREMENT PRIMARY KEY,
    nome varchar(60),
    matricula varchar(30),
    fk_areas_id smallint
);

CREATE TABLE tema (
    id smallint AUTO_INCREMENT PRIMARY KEY,
    nome varchar(60),
    descricao varchar(100),
    fk_areas_id smallint
);

CREATE TABLE aluno_tema (
    id smallint AUTO_INCREMENT PRIMARY KEY,
    fk_tema_id smallint,
    fk_professores_id smallint,
    fk_alunos_id smallint
);

CREATE TABLE alunos (
    id smallint AUTO_INCREMENT PRIMARY KEY,
    nome varchar(60),
    matricula varchar(30)
);
 
ALTER TABLE professores ADD CONSTRAINT FK_professores_2
    FOREIGN KEY (fk_areas_id)
    REFERENCES areas (id)
    ON DELETE CASCADE;
 
ALTER TABLE tema ADD CONSTRAINT FK_tema_2
    FOREIGN KEY (fk_areas_id)
    REFERENCES areas (id)
    ON DELETE RESTRICT;
 
ALTER TABLE aluno_tema ADD CONSTRAINT FK_aluno_tema_2
    FOREIGN KEY (fk_tema_id)
    REFERENCES tema (id)
    ON DELETE RESTRICT;
 
ALTER TABLE aluno_tema ADD CONSTRAINT FK_aluno_tema_3
    FOREIGN KEY (fk_professores_id)
    REFERENCES professores (id)
    ON DELETE SET NULL;
 
ALTER TABLE aluno_tema ADD CONSTRAINT FK_aluno_tema_4
    FOREIGN KEY (fk_alunos_id)
    REFERENCES alunos (id)
    ON DELETE RESTRICT;