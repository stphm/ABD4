#! /bin/python3.7

from crypt import methods
from re import M, TEMPLATE
from sre_compile import isstring
from flask import Flask, jsonify
from flask.json.tag import JSONTag
from flask import request as flask_request
import sqlalchemy
from sqlalchemy.ext.declarative import declarative_base
from sqlalchemy.orm.session import sessionmaker
from importlib import import_module
#from models.dbmodel import StudentProg, User, Correction
#from models.argsHandler import ArgsHandler
#from models.workerThread import WorkerThread
from model import Booking, BookingPayment, User, BookingTicket
import shutil
import os
import traceback
import time, threading
import sys
import subprocess
import pprint
import requests
import json
from functools import wraps
import jwt
import psycopg2
import datetime
import cumul


engine = sqlalchemy.create_engine(
    "postgresql+psycopg2://monkey:vdm@localhost/vdm_escape_game",
    isolation_level = "REPEATABLE READ"
)

app = Flask(__name__)

# api = Api(app)

app.config["SECRET_KEY"]='ioancoancoaiozunaconocn&in09841097421'
app.config["BACK_KEY"]='back001'

Base = declarative_base()
# Base.metadata.create_all(engine)

Session = sqlalchemy.orm.sessionmaker()
Session.configure(bind=engine)
session = Session()

TEMPORARY_CORRECT_OUTPUT = "salut"

#AUTOCORRECTOR_EXE = "./executable/src/autocorrector.py"
CUMUL_EXE = "executable/src/autocorrector.py"

class Controller:
    def __init__(self) -> None:
        self.exe = CUMUL_EXE
        # self.args_handler = ArgsHandler(self)
        app.add_url_rule("/nresa", "nb_reservations", self.nresa, methods=["GET"])
        app.add_url_rule("/amountResa", "amount_reservations", self.amountResa, methods=["GET"])
        app.add_url_rule("/nclients", "nb_clients", self.nclients, methods=["GET"])
        app.add_url_rule("/nresaPerDay","nb_resa_per_day", self.nresaPerDay, methods=["GET"])
        app.add_url_rule("/amountResaPerDay","amount_resa_per_day", self.amountResaPerDay, methods=["GET"])
        app.add_url_rule("/nclientsPerDay","nb_clients_per_day", self.nclientsPerDay, methods=["GET"])
        app.add_url_rule("/nresaPerWeek","nb_resa_per_week", self.nresaPerWeek, methods=["GET"])
        app.add_url_rule("/amountResaPerWeek","amount_resa_per_week", self.amountResaPerWeek, methods=["GET"])
        app.add_url_rule("/nclientsPerWeek","nb_clients_per_week", self.nclientsPerWeek, methods=["GET"])
        app.add_url_rule("/nresaPerMonth","nb_resa_per_month", self.nresaPerMonth, methods=["GET"])
        app.add_url_rule("/amountResaPerMonth","amount_resa_per_month", self.amountResaPerMonth, methods=["GET"])
        app.add_url_rule("/nclientsPerMonth","nb_clients_per_Month", self.nclientsPerMonth, methods=["GET"])

        app.run(debug=True, host='0.0.0.0', port='3000')
    
    def nresa(self):
        bookings: Booking = session.query(Booking).all()
        print(bookings)
        return jsonify({"Value": len(bookings)}), 200

    def nclients(self):
        clients: list[User] = session.query(User).all()
        return jsonify({"total": len(clients)}), 200


    def amountResa(self):
        tickets = session.query(BookingPayment).all()
        total = 0.0
        for t in tickets:
            total += t.value
        return jsonify({"total": total}), 200
    
    def nresaPerDay(self):
        bookings: list[Booking] = session.query(Booking).all()
        res = {}
        for b in bookings:
            b: Booking
            d: datetime.datetime = b.created_at
            strDate = f"{d.year}-{d.month:0>2}-{d.day:0>2}"
            if strDate not in res:
                res[strDate] = 1
            else:
                res[strDate] += 1
        return jsonify(res), 200

    def nclientsPerDay(self):
        bookings: list[Booking] = session.query(Booking).all()
        seen = []
        res = {}
        for b in bookings:
            d: datetime.datetime = b.created_at
            tickets = b.tickets
            strDate = f"{d.year}-{d.month:0>2}-{d.day:0>2}"
            if strDate not in res:
                res[strDate] = len(tickets)
            else:
                res[strDate] += len(tickets)
        return jsonify(res), 200

    def amountResaPerDay(self):
        bookings: list[BookingPayment] = session.query(BookingPayment).all()
        print(bookings)
        filename = "amountResaPerDay.csv"
        with open(filename, "w+") as file:
            file.write("DATE;VALUE\n")
            for b in bookings:
                d = b.created_at
                d: datetime.datetime
                file.write(f"{d.year}-{d.month:0>2}-{d.day:0>2};{b.value}\n")
        data = cumul.readFile(filename, ["VALUE"] ,["DATE"], ";")
        data = cumul.cumul(data)
        res = dict(data[1:])
        return jsonify(res), 200

    def nresaPerWeek(self):
        bookings: list[Booking] = session.query(Booking).all()
        res = {}
        for b in bookings:
            d: datetime.datetime = b.created_at
            strDate = f"{d.year}-{d.isocalendar()[1]:0>2}"
            if strDate not in res:
                res[strDate] = 1
            else:
                res[strDate] += 1
        return jsonify(res), 200
    
    def amountResaPerWeek(self):
        bookings: list[BookingPayment] = session.query(BookingPayment).all()
        res = {}
        for b in bookings:
            d: datetime.datetime = b.created_at
            strDate = f"{d.year}-{d.isocalendar()[1]:0>2}"
            if strDate not in res:
                res[strDate] = b.value
            else:
                res[strDate] += b.value
        return jsonify(res), 200

    def nclientsPerWeek(self):
        bookings: list[Booking] = session.query(Booking).all()
        res = {}
        for b in bookings:
            d: datetime.datetime = b.created_at
            strDate = f"{d.year}-{d.isocalendar()[1]:0>2}"
            if strDate not in res:
                res[strDate] = len(b.tickets)
            else:
                res[strDate] += len(b.tickets)
        return jsonify(res), 200

    def nresaPerMonth(self):
        bookings: list[Booking] = session.query(Booking).all()
        res = {}
        for b in bookings:
            d: datetime.datetime = b.created_at
            strDate = f"{d.year}-{d.month:0>2}"
            if strDate not in res:
                res[strDate] = 1
            else:
                res[strDate] += 1
        return jsonify(res), 200

    def amountResaPerMonth(self):
        bookings: list[BookingPayment] = session.query(BookingPayment).all()
        res = {}
        for b in bookings:
            d: datetime.datetime = b.created_at
            strDate = f"{d.year}-{d.month:0>2}"
            if strDate not in res:
                res[strDate] = b.value
            else:
                res[strDate] += b.value
        return jsonify(res), 200

    def nclientsPerMonth(self):
        bookings: list[Booking] = session.query(Booking).all()
        res = {}
        for b in bookings:
            d: datetime.datetime = b.created_at
            strDate = f"{d.year}-{d.month:0>2}"
            if strDate not in res:
                res[strDate] = len(b.tickets)
            else:
                res[strDate] += len(b.tickets)
        return jsonify(res), 200

if __name__ == "__main__":
    Controller()

