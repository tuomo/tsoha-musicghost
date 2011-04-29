CREATE TABLE list (
    name        TEXT PRIMARY KEY,
    public      BOOLEAN NOT NULL
);

CREATE TABLE artist (
    id          SERIAL PRIMARY KEY,
    name        TEXT NOT NULL,
    sortname    TEXT NOT NULL,
    homepage    TEXT,
    annotation  TEXT
);

CREATE TABLE type (
    name        TEXT PRIMARY KEY
);

CREATE TABLE format (
    name        TEXT PRIMARY KEY
);

CREATE TABLE packaging (
    name        TEXT PRIMARY KEY
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
    box_id      INT REFERENCES record(id),
    type        TEXT REFERENCES type(name) NOT NULL,
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
    list        TEXT REFERENCES list(name),
    PRIMARY KEY (record, list)
);

INSERT INTO type (name) VALUES ('Album'), ('Single'), ('EP'), ('Compilation'),
    ('Soundtrack'), ('Interview'), ('Live'), ('Other');

INSERT INTO list (name, public) VALUES ('Default', TRUE);

INSERT INTO format (name) VALUES ('CD'), ('2CD'),
    ('DVD'), ('2DVD'), ('CD+DVD'), ('DVD+CD');

INSERT INTO packaging (name) VALUES ('Jewel case'), ('Digipack'),
    ('Keep case'), ('Other');
