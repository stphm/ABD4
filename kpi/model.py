from datetime import datetime
import sqlalchemy
from sqlalchemy import sql
from sqlalchemy.ext.declarative import declarative_base
from sqlalchemy import ForeignKey
from sqlalchemy.orm import relationship, backref
import re

from sqlalchemy.sql.expression import false

Base = declarative_base()

class Booking(Base):
    __tablename__ = "booking"
    id = sqlalchemy.Column(sqlalchemy.Integer, primary_key=True)
    created_at = sqlalchemy.Column(sqlalchemy.TIMESTAMP(), server_default="CURRENT_TIMESTAMP")
    updated_at = sqlalchemy.Column(sqlalchemy.TIMESTAMP(), server_default="CURRENT_TIMESTAMP")
    id_ref_status = sqlalchemy.Column(sqlalchemy.Integer, ForeignKey("reference_booking_status.id"))
    payment_id = sqlalchemy.Column(sqlalchemy.Integer, ForeignKey("booking_payment.id"))
    customer_id = sqlalchemy.Column(sqlalchemy.Integer, ForeignKey("users.id"))
    session_id = sqlalchemy.Column(sqlalchemy.Integer, ForeignKey("game_room_session.id"))
    tickets = relationship("BookingTicket", backref="booking")

class BookingPayment(Base):
    __tablename__ = "booking_payment"
    id = sqlalchemy.Column(sqlalchemy.Integer, primary_key=True)
    value = sqlalchemy.Column(sqlalchemy.Float, nullable=False)
    created_at = sqlalchemy.Column(sqlalchemy.TIMESTAMP(), server_default="CURRENT_TIMESTAMP")
    updated_at = sqlalchemy.Column(sqlalchemy.TIMESTAMP(), server_default="CURRENT_TIMESTAMP")
    validated_at = sqlalchemy.Column(sqlalchemy.TIMESTAMP(), server_default="CURRENT_TIMESTAMP")
    id_ref_payment_status = sqlalchemy.Column(sqlalchemy.Integer, ForeignKey("reference_booking_payment_status.id"))


class BookingTicket(Base):
    __tablename__ = "booking_ticket"
    id = sqlalchemy.Column(sqlalchemy.Integer, primary_key=True)
    booking_id = sqlalchemy.Column(sqlalchemy.Integer, ForeignKey("booking.id"))
    reference_pricing_id = sqlalchemy.Column(sqlalchemy.Integer, ForeignKey("reference_booking_ticket_pricing.id"))
    owner_id = sqlalchemy.Column(sqlalchemy.Integer, ForeignKey("users.id"))
    id_ref_owner_civility = sqlalchemy.Column(sqlalchemy.Integer, ForeignKey("reference_people_civility.id"))
    price = sqlalchemy.Column(sqlalchemy.Float, nullable=False)
    owner_first_name = sqlalchemy.Column(sqlalchemy.String(255), nullable=False)
    owner_last_name = sqlalchemy.Column(sqlalchemy.String(255), nullable=False)
    owner_age = sqlalchemy.Column(sqlalchemy.Integer, nullable=False)

class User(Base):
    __tablename__ = "users"
    id = sqlalchemy.Column(sqlalchemy.Integer, primary_key=True)

# class File(Base):
#     __tablename__ = "files"
#     id = sqlalchemy.Column(sqlalchemy.Integer, primary_key=True)
#     source = sqlalchemy.Column(sqlalchemy.String(255), nullable=False)
#     createdAt = sqlalchemy.Column(sqlalchemy.TIMESTAMP(), server_default="CURRENT_TIMESTAMP")
#     updatedAt = sqlalchemy.Column(sqlalchemy.TIMESTAMP(), server_default="CURRENT_TIMESTAMP")
#     userId = sqlalchemy.Column(sqlalchemy.Integer, ForeignKey("users.id", ondelete='CASCADE'))
#     user = relationship("User", back_populates="files")

# class Correction(Base):
#     __tablename__ = "corrections"
#     id = sqlalchemy.Column(sqlalchemy.Integer, primary_key=True)
#     name = sqlalchemy.Column(sqlalchemy.String(255), nullable=False)
#     control_prog = sqlalchemy.Column(sqlalchemy.String(255), nullable=False)
#     result = sqlalchemy.Column(sqlalchemy.String(255), nullable=False)
#     createdAt = sqlalchemy.Column(sqlalchemy.TIMESTAMP(), server_default="CURRENT_TIMESTAMP")
#     updatedAt = sqlalchemy.Column(sqlalchemy.TIMESTAMP(), server_default="CURRENT_TIMESTAMP")
#     userId = sqlalchemy.Column(sqlalchemy.Integer, ForeignKey("users.id", ondelete='CASCADE'))
#     user = relationship("User", back_populates="correction")
#     student_progs = relationship("StudentProg", backref="correction")

# class StudentProg(Base):
#     __tablename__ = "studentProgs"
#     id = sqlalchemy.Column(sqlalchemy.Integer, primary_key=True)
#     source = sqlalchemy.Column(sqlalchemy.Sequence(255), nullable=False)
#     correctionId = sqlalchemy.Column(sqlalchemy.Integer, ForeignKey("corrections.id"))
#     userId = sqlalchemy.Column(sqlalchemy.Integer, ForeignKey("users.id", ondelete='CASCADE'))
