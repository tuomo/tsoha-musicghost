INSERT INTO list (name, public) VALUES ('Collection', TRUE);
INSERT INTO list (name, public) VALUES ('Shopping list', FALSE);

INSERT INTO artist (name, sortname, homepage, annotation)
    VALUES ('Artist 1', 'Artist 1', 'http://artist1.com', 'aöfjfkfjkfk');
INSERT INTO artist (name, sortname, homepage, annotation)
    VALUES ('Artist 2', 'Artist 2', 'http://artist2.com', 'rjlökfjöldlkj');
INSERT INTO artist (name, sortname, homepage, annotation)
    VALUES ('Foo Bar', 'Bar, Foo', 'http://asdf.com', 'requiöasfjköfk');

INSERT INTO format (name) VALUES ('CD'), ('2CD'), ('DVD'), ('CD+DVD');

INSERT INTO packaging (name) VALUES ('Jewel case'), ('Digipack'), ('Slimcase');

INSERT INTO label (name, homepage, annotation)
    VALUES ('Label 1', 'http://label1.com', 'asjadfkaöfkakl');

INSERT INTO record (
    artist,
    title,
    box_status,
    type,
    first_year,
    this_year,
    format,
    packaging,
    label,
    lent
) VALUES (
    1,
    'Album 1',
    'normal',
    'album',
    2000,
    2002,
    'CD',
    'Jewel case',
    1,
    FALSE
), (
    2,
    'Album 2',
    'normal',
    'album',
    2010,
    2010,
    'CD+DVD',
    'Digipack',
    1,
    FALSE
);

INSERT INTO record_list (record, list) VALUES (1, 1);
INSERT INTO record_list (record, list) VALUES (2, 1);
