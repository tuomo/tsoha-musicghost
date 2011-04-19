CREATE TYPE record_type AS ENUM ('album', 'single', 'EP', 'compilation',
    'soundtrack', 'interview', 'live', 'other');

CREATE TYPE box_status AS ENUM ('normal', 'box', 'item');

CREATE TABLE list (
    id          SERIAL PRIMARY KEY,
    name        TEXT NOT NULL,
    public      BOOLEAN NOT NULL
);

CREATE TABLE artist (
    id          SERIAL PRIMARY KEY,
    name        TEXT NOT NULL,
    sortname    TEXT NOT NULL,
    homepage    TEXT,
    annotation  TEXT
);

CREATE TABLE format (
    id          SERIAL PRIMARY KEY,
    name        TEXT NOT NULL
);

CREATE TABLE packaging (
    id          SERIAL PRIMARY KEY,
    name        TEXT NOT NULL
);

CREATE TABLE label (
    id          SERIAL PRIMARY KEY,
    name        TEXT NOT NULL,
    homepage    TEXT,
    annotation  TEXT
);

CREATE TABLE record (
    id          SERIAL PRIMARY KEY,
    artist      INT REFERENCES artist(id) NOT NULL,
    title       TEXT NOT NULL,
    box_status  box_status NOT NULL,
    box_id      INT REFERENCES record(id),
    type        record_type NOT NULL,
    first_year  INT,
    this_year   INT,
    format      TEXT REFERENCES format(name),
    packaging   TEXT REFERENCES packaging(name),
    label       INT REFERENCES label(id),
    limited     BOOLEAN,
    ltd_num     INT,
    added       DATE,
    lent        BOOLEAN NOT NULL,
    borrower    TEXT,
    annotation  TEXT
);

CREATE TABLE record_list (
    record      INT REFERENCES record(id),
    list        INT REFERENCES list(id),
    PRIMARY KEY (record, list)
);

INSERT INTO list (name, public) VALUES ('Default', TRUE);

INSERT INTO format (name) VALUES ('CD'), ('2CD'),
    ('DVD'), ('2DVD'), ('CD+DVD'), ('DVD+CD');

INSERT INTO packaging (name) VALUES ('Jewel case'), ('Digipack'),
    ('Keep case'), ('Other');