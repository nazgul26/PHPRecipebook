
FROM postgres:11-alpine

LABEL software.version="5.1.5"
LABEL container.version="0.1"

COPY db_schema.sql /docker-entrypoint-initdb.d/
