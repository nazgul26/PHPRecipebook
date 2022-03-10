#!/bin/sh

bin/cake migrations migrate
bin/cake migrations seed