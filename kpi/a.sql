--
-- PostgreSQL database dump
--

-- Dumped from database version 15.0
-- Dumped by pg_dump version 15.0

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: notify_messenger_messages(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.notify_messenger_messages() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
            BEGIN
                PERFORM pg_notify('messenger_messages', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$;


ALTER FUNCTION public.notify_messenger_messages() OWNER TO postgres;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: booking; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.booking (
    id integer NOT NULL,
    id_ref_status integer NOT NULL,
    payment_id integer,
    customer_id integer NOT NULL,
    session_id integer NOT NULL,
    created_at timestamp(0) without time zone NOT NULL,
    updated_at timestamp(0) without time zone NOT NULL
);


ALTER TABLE public.booking OWNER TO postgres;

--
-- Name: COLUMN booking.created_at; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.booking.created_at IS '(DC2Type:datetime_immutable)';


--
-- Name: COLUMN booking.updated_at; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.booking.updated_at IS '(DC2Type:datetime_immutable)';


--
-- Name: booking_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.booking_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.booking_id_seq OWNER TO postgres;

--
-- Name: booking_payment; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.booking_payment (
    id integer NOT NULL,
    id_ref_payment_status integer NOT NULL,
    value double precision NOT NULL,
    created_at timestamp(0) without time zone NOT NULL,
    updated_at timestamp(0) without time zone NOT NULL,
    validated_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone
);


ALTER TABLE public.booking_payment OWNER TO postgres;

--
-- Name: COLUMN booking_payment.created_at; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.booking_payment.created_at IS '(DC2Type:datetime_immutable)';


--
-- Name: COLUMN booking_payment.updated_at; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.booking_payment.updated_at IS '(DC2Type:datetime_immutable)';


--
-- Name: COLUMN booking_payment.validated_at; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.booking_payment.validated_at IS '(DC2Type:datetime_immutable)';


--
-- Name: booking_payment_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.booking_payment_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.booking_payment_id_seq OWNER TO postgres;

--
-- Name: booking_ticket; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.booking_ticket (
    id integer NOT NULL,
    booking_id integer NOT NULL,
    reference_pricing_id integer NOT NULL,
    owner_id integer,
    id_ref_owner_civility integer,
    price double precision NOT NULL,
    owner_first_name character varying(255),
    owner_last_name character varying(255),
    owner_age integer
);


ALTER TABLE public.booking_ticket OWNER TO postgres;

--
-- Name: booking_ticket_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.booking_ticket_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.booking_ticket_id_seq OWNER TO postgres;

--
-- Name: booking_ticket_pricing; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.booking_ticket_pricing (
    id integer NOT NULL,
    id_ref_pricing integer NOT NULL,
    value double precision NOT NULL
);


ALTER TABLE public.booking_ticket_pricing OWNER TO postgres;

--
-- Name: booking_ticket_pricing_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.booking_ticket_pricing_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.booking_ticket_pricing_id_seq OWNER TO postgres;

--
-- Name: doctrine_migration_versions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.doctrine_migration_versions (
    version character varying(191) NOT NULL,
    executed_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    execution_time integer
);


ALTER TABLE public.doctrine_migration_versions OWNER TO postgres;

--
-- Name: game_room; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.game_room (
    id integer NOT NULL,
    theme_id integer NOT NULL,
    duration integer NOT NULL,
    is_vr boolean NOT NULL
);


ALTER TABLE public.game_room OWNER TO postgres;

--
-- Name: game_room_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.game_room_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.game_room_id_seq OWNER TO postgres;

--
-- Name: game_room_session; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.game_room_session (
    id integer NOT NULL,
    id_game_room integer NOT NULL,
    start_at timestamp(0) without time zone NOT NULL,
    end_at timestamp(0) without time zone NOT NULL
);


ALTER TABLE public.game_room_session OWNER TO postgres;

--
-- Name: COLUMN game_room_session.start_at; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.game_room_session.start_at IS '(DC2Type:datetime_immutable)';


--
-- Name: COLUMN game_room_session.end_at; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.game_room_session.end_at IS '(DC2Type:datetime_immutable)';


--
-- Name: game_room_session_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.game_room_session_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.game_room_session_id_seq OWNER TO postgres;

--
-- Name: messenger_messages; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.messenger_messages (
    id bigint NOT NULL,
    body text NOT NULL,
    headers text NOT NULL,
    queue_name character varying(190) NOT NULL,
    created_at timestamp(0) without time zone NOT NULL,
    available_at timestamp(0) without time zone NOT NULL,
    delivered_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone
);


ALTER TABLE public.messenger_messages OWNER TO postgres;

--
-- Name: messenger_messages_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.messenger_messages_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.messenger_messages_id_seq OWNER TO postgres;

--
-- Name: messenger_messages_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.messenger_messages_id_seq OWNED BY public.messenger_messages.id;


--
-- Name: reference_booking_payment_status; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.reference_booking_payment_status (
    id integer NOT NULL,
    label character varying(255) NOT NULL
);


ALTER TABLE public.reference_booking_payment_status OWNER TO postgres;

--
-- Name: reference_booking_payment_status_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.reference_booking_payment_status_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.reference_booking_payment_status_id_seq OWNER TO postgres;

--
-- Name: reference_booking_status; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.reference_booking_status (
    id integer NOT NULL,
    label character varying(255) NOT NULL
);


ALTER TABLE public.reference_booking_status OWNER TO postgres;

--
-- Name: reference_booking_status_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.reference_booking_status_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.reference_booking_status_id_seq OWNER TO postgres;

--
-- Name: reference_booking_ticket_pricing; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.reference_booking_ticket_pricing (
    id integer NOT NULL,
    label character varying(255) NOT NULL,
    current_value double precision NOT NULL
);


ALTER TABLE public.reference_booking_ticket_pricing OWNER TO postgres;

--
-- Name: reference_booking_ticket_pricing_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.reference_booking_ticket_pricing_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.reference_booking_ticket_pricing_id_seq OWNER TO postgres;

--
-- Name: reference_game_room_theme; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.reference_game_room_theme (
    id integer NOT NULL,
    label character varying(255) NOT NULL
);


ALTER TABLE public.reference_game_room_theme OWNER TO postgres;

--
-- Name: reference_game_room_theme_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.reference_game_room_theme_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.reference_game_room_theme_id_seq OWNER TO postgres;

--
-- Name: reference_people_civility; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.reference_people_civility (
    id integer NOT NULL,
    label character varying(20) NOT NULL
);


ALTER TABLE public.reference_people_civility OWNER TO postgres;

--
-- Name: reference_people_civility_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.reference_people_civility_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.reference_people_civility_id_seq OWNER TO postgres;

--
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users (
    id integer NOT NULL,
    civility_id integer NOT NULL,
    email character varying(180) NOT NULL,
    roles json NOT NULL,
    password character varying(255) NOT NULL,
    first_name character varying(255) NOT NULL,
    last_name character varying(255) NOT NULL,
    age integer NOT NULL,
    created_at timestamp(0) without time zone NOT NULL
);


ALTER TABLE public.users OWNER TO postgres;

--
-- Name: COLUMN users.created_at; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.users.created_at IS '(DC2Type:datetime_immutable)';


--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.users_id_seq OWNER TO postgres;

--
-- Name: users_sessions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users_sessions (
    sess_id character varying(128) NOT NULL,
    sess_data bytea NOT NULL,
    sess_lifetime integer NOT NULL,
    sess_time integer NOT NULL
);


ALTER TABLE public.users_sessions OWNER TO postgres;

--
-- Name: messenger_messages id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.messenger_messages ALTER COLUMN id SET DEFAULT nextval('public.messenger_messages_id_seq'::regclass);


--
-- Data for Name: booking; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.booking (id, id_ref_status, payment_id, customer_id, session_id, created_at, updated_at) FROM stdin;
1	2	1	3	1	2023-03-02 20:28:53	2023-03-02 20:28:53
2	2	2	4	2	2023-03-02 20:28:54	2023-03-02 20:28:54
3	2	3	5	3	2023-03-02 20:28:54	2023-03-02 20:28:54
4	2	4	6	4	2023-03-02 20:28:54	2023-03-02 20:28:54
5	2	5	7	5	2023-03-02 20:28:55	2023-03-02 20:28:55
6	2	6	8	6	2023-03-02 20:28:55	2023-03-02 20:28:55
7	2	7	9	7	2023-03-02 20:28:56	2023-03-02 20:28:56
8	2	8	10	8	2023-03-02 20:28:57	2023-03-02 20:28:57
9	2	9	11	9	2023-03-02 20:28:58	2023-03-02 20:28:58
10	2	10	12	10	2023-03-02 20:28:59	2023-03-02 20:28:59
11	2	11	13	11	2023-03-02 20:29:00	2023-03-02 20:29:00
12	2	12	14	12	2023-03-02 20:29:01	2023-03-02 20:29:01
13	2	13	15	13	2023-03-02 20:29:02	2023-03-02 20:29:02
14	2	14	16	14	2023-03-02 20:29:03	2023-03-02 20:29:03
15	2	15	17	15	2023-03-02 20:29:04	2023-03-02 20:29:04
16	2	16	18	16	2023-03-02 20:29:05	2023-03-02 20:29:05
17	2	17	19	17	2023-03-02 20:29:06	2023-03-02 20:29:06
18	2	18	20	18	2023-03-02 20:29:07	2023-03-02 20:29:07
19	2	19	21	19	2023-03-02 20:29:08	2023-03-02 20:29:08
20	2	20	22	20	2023-03-02 20:29:09	2023-03-02 20:29:09
21	2	21	23	21	2023-03-02 20:29:15	2023-03-02 20:29:15
22	2	22	24	22	2023-03-02 20:29:16	2023-03-02 20:29:16
23	2	23	25	23	2023-03-02 20:29:16	2023-03-02 20:29:16
24	2	24	26	24	2023-03-02 20:29:17	2023-03-02 20:29:17
25	2	25	27	25	2023-03-02 20:29:17	2023-03-02 20:29:17
26	2	26	28	26	2023-03-02 20:29:17	2023-03-02 20:29:17
27	2	27	29	27	2023-03-02 20:29:18	2023-03-02 20:29:18
28	2	28	30	28	2023-03-02 20:29:19	2023-03-02 20:29:19
29	2	29	31	29	2023-03-02 20:29:20	2023-03-02 20:29:20
30	2	30	32	30	2023-03-02 20:29:26	2023-03-02 20:29:26
31	2	31	33	31	2023-03-02 20:29:27	2023-03-02 20:29:27
32	2	32	34	32	2023-03-02 20:29:27	2023-03-02 20:29:27
33	2	33	35	33	2023-03-02 20:29:28	2023-03-02 20:29:28
34	2	34	36	34	2023-03-02 20:29:28	2023-03-02 20:29:28
35	2	35	37	35	2023-03-02 20:29:29	2023-03-02 20:29:29
\.


--
-- Data for Name: booking_payment; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.booking_payment (id, id_ref_payment_status, value, created_at, updated_at, validated_at) FROM stdin;
1	2	9.4	2023-03-02 20:28:53	2023-03-02 20:28:53	2023-03-02 20:28:53
2	2	6.8	2023-03-02 20:28:54	2023-03-02 20:28:54	2023-03-02 20:28:54
3	2	9.4	2023-03-02 20:28:54	2023-03-02 20:28:54	2023-03-02 20:28:54
4	2	32.4	2023-03-02 20:28:54	2023-03-02 20:28:54	2023-03-02 20:28:54
5	2	35	2023-03-02 20:28:55	2023-03-02 20:28:55	2023-03-02 20:28:55
6	2	35	2023-03-02 20:28:55	2023-03-02 20:28:55	2023-03-02 20:28:55
7	2	35	2023-03-02 20:28:56	2023-03-02 20:28:56	2023-03-02 20:28:56
8	2	32.4	2023-03-02 20:28:57	2023-03-02 20:28:57	2023-03-02 20:28:57
9	2	32.4	2023-03-02 20:28:58	2023-03-02 20:28:58	2023-03-02 20:28:58
10	2	31	2023-03-02 20:28:59	2023-03-02 20:28:59	2023-03-02 20:28:59
11	2	32.4	2023-03-02 20:29:00	2023-03-02 20:29:00	2023-03-02 20:29:00
12	2	30.4	2023-03-02 20:29:01	2023-03-02 20:29:01	2023-03-02 20:29:01
13	2	33	2023-03-02 20:29:02	2023-03-02 20:29:02	2023-03-02 20:29:02
14	2	29.8	2023-03-02 20:29:03	2023-03-02 20:29:03	2023-03-02 20:29:03
15	2	29.8	2023-03-02 20:29:04	2023-03-02 20:29:04	2023-03-02 20:29:04
16	2	32.4	2023-03-02 20:29:05	2023-03-02 20:29:05	2023-03-02 20:29:05
17	2	29.8	2023-03-02 20:29:06	2023-03-02 20:29:06	2023-03-02 20:29:06
18	2	32.4	2023-03-02 20:29:07	2023-03-02 20:29:07	2023-03-02 20:29:07
19	2	27.2	2023-03-02 20:29:08	2023-03-02 20:29:08	2023-03-02 20:29:08
20	2	30.4	2023-03-02 20:29:09	2023-03-02 20:29:09	2023-03-02 20:29:09
21	2	9.4	2023-03-02 20:29:15	2023-03-02 20:29:15	2023-03-02 20:29:15
22	2	13.6	2023-03-02 20:29:16	2023-03-02 20:29:16	2023-03-02 20:29:16
23	2	18.8	2023-03-02 20:29:16	2023-03-02 20:29:16	2023-03-02 20:29:16
24	2	23	2023-03-02 20:29:17	2023-03-02 20:29:17	2023-03-02 20:29:17
25	2	23	2023-03-02 20:29:17	2023-03-02 20:29:17	2023-03-02 20:29:17
26	2	23	2023-03-02 20:29:17	2023-03-02 20:29:17	2023-03-02 20:29:17
27	2	25.6	2023-03-02 20:29:18	2023-03-02 20:29:18	2023-03-02 20:29:18
28	2	20.4	2023-03-02 20:29:19	2023-03-02 20:29:19	2023-03-02 20:29:19
29	2	23	2023-03-02 20:29:20	2023-03-02 20:29:20	2023-03-02 20:29:20
30	2	37.6	2023-03-02 20:29:26	2023-03-02 20:29:26	2023-03-02 20:29:26
31	2	35	2023-03-02 20:29:27	2023-03-02 20:29:27	2023-03-02 20:29:27
32	2	37.6	2023-03-02 20:29:27	2023-03-02 20:29:27	2023-03-02 20:29:27
33	2	35	2023-03-02 20:29:28	2023-03-02 20:29:28	2023-03-02 20:29:28
34	2	32.4	2023-03-02 20:29:28	2023-03-02 20:29:28	2023-03-02 20:29:28
35	2	35	2023-03-02 20:29:29	2023-03-02 20:29:29	2023-03-02 20:29:29
\.


--
-- Data for Name: booking_ticket; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.booking_ticket (id, booking_id, reference_pricing_id, owner_id, id_ref_owner_civility, price, owner_first_name, owner_last_name, owner_age) FROM stdin;
1	1	4	3	\N	9.4	\N	\N	\N
2	2	1	4	\N	6.8	\N	\N	\N
3	3	4	5	\N	9.4	\N	\N	\N
4	4	2	6	\N	6.8	\N	\N	\N
5	4	4	\N	2	9.4	Hazle	Muhammad	43
6	4	2	\N	1	6.8	Rosina	Alva	65
7	4	4	\N	1	9.4	Jarod	Leonel	24
8	5	4	7	\N	9.4	\N	\N	\N
9	5	4	\N	2	9.4	Hazle	Muhammad	43
10	5	2	\N	1	6.8	Rosina	Alva	65
11	5	4	\N	1	9.4	Jarod	Leonel	24
12	6	4	8	\N	9.4	\N	\N	\N
13	6	4	\N	2	9.4	Hazle	Muhammad	43
14	6	2	\N	1	6.8	Rosina	Alva	65
15	6	4	\N	1	9.4	Jarod	Leonel	24
16	7	4	9	\N	9.4	\N	\N	\N
17	7	4	\N	2	9.4	Hazle	Muhammad	43
18	7	2	\N	1	6.8	Rosina	Alva	65
19	7	4	\N	1	9.4	Jarod	Leonel	24
20	8	2	10	\N	6.8	\N	\N	\N
21	8	4	\N	2	9.4	Hazle	Muhammad	43
22	8	2	\N	1	6.8	Rosina	Alva	65
23	8	4	\N	1	9.4	Jarod	Leonel	24
24	9	4	11	\N	9.4	\N	\N	\N
25	9	2	\N	2	6.8	Antonietta	Mac	63
26	9	2	\N	1	6.8	Rosina	Alva	65
27	9	4	\N	1	9.4	Jarod	Leonel	24
28	10	3	12	\N	7.4	\N	\N	\N
29	10	2	\N	2	6.8	Garrison	Rosemary	64
30	10	3	\N	1	7.4	Brielle	Sincere	27
31	10	4	\N	1	9.4	Jarod	Leonel	24
32	11	4	13	\N	9.4	\N	\N	\N
33	11	1	\N	1	6.8	Maureen	Marc	22
34	11	2	\N	2	6.8	Stephanie	Keagan	58
35	11	4	\N	2	9.4	Winfield	Elise	28
36	12	2	14	\N	6.8	\N	\N	\N
37	12	3	\N	1	7.4	Stephania	Jefferey	34
38	12	1	\N	1	6.8	Justus	Camila	13
39	12	4	\N	2	9.4	Winfield	Elise	28
40	13	4	15	\N	9.4	\N	\N	\N
41	13	3	\N	1	7.4	Stephania	Jefferey	34
42	13	1	\N	1	6.8	Justus	Camila	13
43	13	4	\N	2	9.4	Winfield	Elise	28
44	14	2	16	\N	6.8	\N	\N	\N
45	14	2	\N	2	6.8	Frankie	Ismael	64
46	14	1	\N	1	6.8	Justus	Camila	13
47	14	4	\N	2	9.4	Winfield	Elise	28
48	15	1	17	\N	6.8	\N	\N	\N
49	15	2	\N	2	6.8	Frankie	Ismael	64
50	15	1	\N	1	6.8	Justus	Camila	13
51	15	4	\N	2	9.4	Winfield	Elise	28
52	16	4	18	\N	9.4	\N	\N	\N
53	16	2	\N	2	6.8	Wendell	Frieda	64
54	16	4	\N	2	9.4	Jewel	Danial	29
55	16	2	\N	1	6.8	Jonas	Margarete	59
56	17	1	19	\N	6.8	\N	\N	\N
57	17	2	\N	2	6.8	Wendell	Frieda	64
58	17	4	\N	2	9.4	Jewel	Danial	29
59	17	2	\N	1	6.8	Jonas	Margarete	59
60	18	4	20	\N	9.4	\N	\N	\N
61	18	2	\N	2	6.8	Wendell	Frieda	64
62	18	4	\N	2	9.4	Jewel	Danial	29
63	18	2	\N	1	6.8	Jonas	Margarete	59
64	19	1	21	\N	6.8	\N	\N	\N
65	19	2	\N	2	6.8	Sincere	Roosevelt	60
66	19	1	\N	2	6.8	Granville	Guiseppe	53
67	19	1	\N	1	6.8	Grayce	Tessie	5
68	20	4	22	\N	9.4	\N	\N	\N
69	20	1	\N	1	6.8	Nat	Federico	14
70	20	3	\N	2	7.4	Neha	Nyah	26
71	20	1	\N	1	6.8	Grayce	Tessie	5
72	21	4	23	\N	9.4	\N	\N	\N
73	22	1	24	\N	6.8	\N	\N	\N
74	22	2	\N	1	6.8	Katelin	Florence	65
75	23	4	25	\N	9.4	\N	\N	\N
76	23	4	\N	1	9.4	Sandrine	Nyasia	37
77	24	2	26	\N	6.8	\N	\N	\N
78	24	4	\N	2	9.4	Jamaal	Miguel	22
79	24	2	\N	1	6.8	Lucas	Colin	61
80	25	2	27	\N	6.8	\N	\N	\N
81	25	4	\N	2	9.4	Jamaal	Miguel	22
82	25	2	\N	1	6.8	Lucas	Colin	61
83	26	2	28	\N	6.8	\N	\N	\N
84	26	4	\N	2	9.4	Jamaal	Miguel	22
85	26	2	\N	1	6.8	Lucas	Colin	61
86	27	4	29	\N	9.4	\N	\N	\N
87	27	4	\N	2	9.4	Jamaal	Miguel	22
88	27	2	\N	1	6.8	Lucas	Colin	61
89	28	1	30	\N	6.8	\N	\N	\N
90	28	2	\N	2	6.8	Eldon	Rose	58
91	28	2	\N	1	6.8	Lucas	Colin	61
92	29	4	31	\N	9.4	\N	\N	\N
93	29	2	\N	2	6.8	Eldon	Rose	58
94	29	2	\N	1	6.8	Lucas	Colin	61
95	30	4	32	\N	9.4	\N	\N	\N
96	30	4	\N	2	9.4	Walker	Ethelyn	45
97	30	4	\N	2	9.4	Brook	Cristian	49
98	30	4	\N	2	9.4	Abby	Antonietta	42
99	31	1	33	\N	6.8	\N	\N	\N
100	31	4	\N	2	9.4	Walker	Ethelyn	45
101	31	4	\N	2	9.4	Brook	Cristian	49
102	31	4	\N	2	9.4	Abby	Antonietta	42
103	32	4	34	\N	9.4	\N	\N	\N
104	32	4	\N	2	9.4	Walker	Ethelyn	45
105	32	4	\N	2	9.4	Brook	Cristian	49
106	32	4	\N	2	9.4	Abby	Antonietta	42
107	33	1	35	\N	6.8	\N	\N	\N
108	33	4	\N	2	9.4	Walker	Ethelyn	45
109	33	4	\N	2	9.4	Brook	Cristian	49
110	33	4	\N	2	9.4	Abby	Antonietta	42
111	34	2	36	\N	6.8	\N	\N	\N
112	34	1	\N	2	6.8	Derick	Isac	15
113	34	4	\N	1	9.4	Lesly	Sarai	29
114	34	4	\N	2	9.4	Lance	Alfonso	51
115	35	4	37	\N	9.4	\N	\N	\N
116	35	1	\N	2	6.8	Zoie	Aletha	5
117	35	4	\N	1	9.4	Lesly	Sarai	29
118	35	4	\N	2	9.4	Lance	Alfonso	51
\.


--
-- Data for Name: booking_ticket_pricing; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.booking_ticket_pricing (id, id_ref_pricing, value) FROM stdin;
\.


--
-- Data for Name: doctrine_migration_versions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.doctrine_migration_versions (version, executed_at, execution_time) FROM stdin;
DoctrineMigrations\\Version20230225101734	2023-03-02 20:28:26	91
DoctrineMigrations\\Version20230302163257	2023-03-02 20:28:26	257
DoctrineMigrations\\Version20230302164606	2023-03-02 20:28:26	1
DoctrineMigrations\\Version20230302181706	2023-03-02 20:28:26	1
\.


--
-- Data for Name: game_room; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.game_room (id, theme_id, duration, is_vr) FROM stdin;
1	1	60	t
2	2	60	t
3	3	60	t
4	4	60	t
5	5	60	t
6	6	60	t
7	7	60	t
8	8	60	t
9	9	60	t
\.


--
-- Data for Name: game_room_session; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.game_room_session (id, id_game_room, start_at, end_at) FROM stdin;
1	1	2023-03-02 21:30:00	2023-03-02 22:30:00
2	2	2023-03-03 10:00:00	2023-03-03 11:00:00
3	3	2023-03-02 05:30:00	2023-03-02 06:30:00
4	4	2023-03-02 00:00:00	2023-03-02 01:00:00
5	5	2023-03-02 12:30:00	2023-03-02 13:30:00
6	4	2023-03-02 10:00:00	2023-03-02 11:00:00
7	3	2023-03-02 21:30:00	2023-03-02 22:30:00
8	6	2023-03-02 08:00:00	2023-03-02 09:00:00
9	7	2023-03-02 00:00:00	2023-03-02 01:00:00
10	7	2023-03-02 16:00:00	2023-03-02 17:00:00
11	1	2023-03-02 00:00:00	2023-03-02 01:00:00
12	4	2023-03-02 08:00:00	2023-03-02 09:00:00
13	8	2023-03-02 16:00:00	2023-03-02 17:00:00
14	2	2023-03-02 03:00:00	2023-03-02 04:00:00
15	6	2023-03-02 03:00:00	2023-03-02 04:00:00
16	7	2023-03-02 16:00:00	2023-03-02 17:00:00
17	3	2023-03-02 05:30:00	2023-03-02 06:30:00
18	3	2023-03-02 16:00:00	2023-03-02 17:00:00
19	1	2023-03-02 12:30:00	2023-03-02 13:30:00
20	7	2023-03-02 00:00:00	2023-03-02 01:00:00
21	6	2023-03-02 18:30:00	2023-03-02 19:30:00
22	2	2023-03-02 18:30:00	2023-03-02 19:30:00
23	6	2023-03-02 10:00:00	2023-03-02 11:00:00
24	7	2023-03-02 18:30:00	2023-03-02 19:30:00
25	2	2023-03-04 16:00:00	2023-03-04 17:00:00
26	1	2023-03-02 16:00:00	2023-03-02 17:00:00
27	7	2023-03-02 08:00:00	2023-03-02 09:00:00
28	4	2023-03-02 21:30:00	2023-03-02 22:30:00
29	5	2023-03-02 03:00:00	2023-03-02 04:00:00
30	3	2023-03-02 10:00:00	2023-03-02 11:00:00
31	8	2023-03-02 00:00:00	2023-03-02 01:00:00
32	4	2023-03-02 10:00:00	2023-03-02 11:00:00
33	9	2023-03-02 00:00:00	2023-03-02 01:00:00
34	6	2023-03-02 12:30:00	2023-03-02 13:30:00
35	6	2023-03-02 21:30:00	2023-03-02 22:30:00
\.


--
-- Data for Name: messenger_messages; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.messenger_messages (id, body, headers, queue_name, created_at, available_at, delivered_at) FROM stdin;
\.


--
-- Data for Name: reference_booking_payment_status; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.reference_booking_payment_status (id, label) FROM stdin;
1	pending
2	validated
3	refused
\.


--
-- Data for Name: reference_booking_status; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.reference_booking_status (id, label) FROM stdin;
1	pending
2	validated
3	refused
\.


--
-- Data for Name: reference_booking_ticket_pricing; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.reference_booking_ticket_pricing (id, label, current_value) FROM stdin;
1	student	6.8
2	senior	6.8
3	reduced	7.4
4	full	9.4
\.


--
-- Data for Name: reference_game_room_theme; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.reference_game_room_theme (id, label) FROM stdin;
1	Soutenance finale
2	Interminable attente chez le medecin
3	Plus de PQ dans les toilettes
4	Diner de famille insoutenable
5	En plein dans la Friendzone
6	Mariage sans alcool
7	Impot sur le revenu
8	Mon compte en banque en fin du mois
9	Greve de la SNCF
\.


--
-- Data for Name: reference_people_civility; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.reference_people_civility (id, label) FROM stdin;
1	M.
2	Mme
3	Autre
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.users (id, civility_id, email, roles, password, first_name, last_name, age, created_at) FROM stdin;
1	1	user@gmail.com	["ROLE_USER"]	$2y$13$86Icf8RkUxhECSA1Ag/S5eoUvD47o9oc1PbGAiClcxcR03zbywQvq	John	Doe	18	2023-03-02 20:28:41
2	2	admin@gmail.com	["ROLE_ADMIN"]	$2y$13$t3AFk9UqGsXE08cOPtSjEuHPlIIej7evhp.1EXuXJiTFa5xXuI10m	Jane	Doe	18	2023-03-02 20:28:41
3	2	sandrine.kenya@gogole.com	["ROLE_USER"]	$2y$13$HJxF5QO.BlDZk8bbt4VXYOizce0Y86fUB7q8HC9lNIQFXShdv5RDa	Kenya	Sandrine	27	2023-03-02 20:28:53
4	2	zion.maryjane@gogole.com	["ROLE_USER"]	$2y$13$XoLEDlApzETu3cNwWc8zu.wXCjLytX6ZXhLFBi0UF431H/2QpgsVC	Maryjane	Zion	6	2023-03-02 20:28:53
5	1	katelyn.arnoldo@gogole.com	["ROLE_USER"]	$2y$13$vPh1AgmWY.MyeB2AXWHObeat62kTv3jHzzO3qcHRkD72GnSzJ6rm.	Arnoldo	Katelyn	27	2023-03-02 20:28:54
6	2	arnaldo.zander@gogole.com	["ROLE_USER"]	$2y$13$bxQuf2y5F2oo8FIsrTxG1eum.FxNmcUHwn9p2nA3hcqQ0TR1Vabn2	Zander	Arnaldo	61	2023-03-02 20:28:54
7	2	frances.ashton@gogole.com	["ROLE_USER"]	$2y$13$sCndXBgtoib4nGa.3lU2z.vM.MCQey36uSQLXPM40AmLtl6LYkWnq	Ashton	Frances	29	2023-03-02 20:28:54
8	2	aurore.tyreek@gogole.com	["ROLE_USER"]	$2y$13$7MMsmgQyP91sj8brP42E5eJnKx0ZFFmMc5Jp64ycSrmMDt83kVR4W	Tyreek	Aurore	30	2023-03-02 20:28:55
9	1	noah.austin@gogole.com	["ROLE_USER"]	$2y$13$cISqutASrbnjhETEKsWxY.VZ9TlxWDxJ70qqhLmRGXMJoomq4yr0G	Austin	Noah	18	2023-03-02 20:28:55
10	2	ella.wayne@gogole.com	["ROLE_USER"]	$2y$13$0wIBc2Hao31DcVqf/FC02OiEOAcN6si96E698NsMuW81awyBlQV7K	Wayne	Ella	60	2023-03-02 20:28:56
11	1	henriette.lucie@gogole.com	["ROLE_USER"]	$2y$13$TOaKsHgZ/4OxO2q6XS6SzOQg7yuzt/RmW9UqubYsoGY9AGVTO3bIe	Lucie	Henriette	43	2023-03-02 20:28:57
12	1	adela.fay@gogole.com	["ROLE_USER"]	$2y$13$n4.yLUbVEy4K3tHc.AuJt.eOqmPCv42PorzTKffCYiGxG0ZW.183e	Fay	Adela	31	2023-03-02 20:28:58
13	2	buster.gail@gogole.com	["ROLE_USER"]	$2y$13$4x8f2pN1lRKRWVXpcTrHWOCk49D/s90Rd6r6QM8bJg88sjsbqeEmq	Gail	Buster	47	2023-03-02 20:28:59
14	1	emmanuel.selena@gogole.com	["ROLE_USER"]	$2y$13$n4szz11/FBnciMgvJqvGtuDDIPSOrtrCVtRpSMF1U/UTxnVA5WHqC	Selena	Emmanuel	57	2023-03-02 20:29:00
15	1	kaitlin.devonte@gogole.com	["ROLE_USER"]	$2y$13$ZngdJ.oVNlUj3rXkX427vueoEhWJD0QM9gckH3BXlZ1L5MbN72m1W	Devonte	Kaitlin	50	2023-03-02 20:29:01
16	2	kayden.judd@gogole.com	["ROLE_USER"]	$2y$13$tICE8/Nc0HQgade1kyl.wuF5b7bTmMZp5FbLhXJ1V7.KIwGzpEI/e	Judd	Kayden	58	2023-03-02 20:29:02
17	1	mustafa.terrill@gogole.com	["ROLE_USER"]	$2y$13$CKDWM9XjDPt2tgecDRaImuMTCrwIlYjgRc8yt8J94G2JNssttLtGq	Terrill	Mustafa	8	2023-03-02 20:29:03
18	2	kraig.selina@gogole.com	["ROLE_USER"]	$2y$13$DKrkMC0B5Ql.2.3PciD4NOLUPeJGNSklrHNB3K6kMU.ZgMR6dFbfK	Selina	Kraig	37	2023-03-02 20:29:04
19	1	nichole.trisha@gogole.com	["ROLE_USER"]	$2y$13$ZoqmCR/ai62f4OjwyQT.qu/iJ65qCYYntkEBUS7PNwCCHuWUxvIHi	Trisha	Nichole	14	2023-03-02 20:29:05
20	1	mario.edward@gogole.com	["ROLE_USER"]	$2y$13$1gosWGUHc0XGY12CyhRiquhQAj3MiS.Xv6j./w5UkoZ4ASVm8MXFm	Edward	Mario	52	2023-03-02 20:29:06
21	2	miguel.beryl@gogole.com	["ROLE_USER"]	$2y$13$dG7CXIO3HzoWM.9SDL.S/uAz9L3EgMFdSexGZt91AY6ZoTua1uPze	Beryl	Miguel	46	2023-03-02 20:29:07
22	2	laverna.mercedes@gogole.com	["ROLE_USER"]	$2y$13$zLTWofy5/EXdtLua7p3J1.zO.BnTR1Yr05Lq/hb1HR7rjqJFa/aGi	Mercedes	Laverna	29	2023-03-02 20:29:08
23	2	bridgette.norris@gogole.com	["ROLE_USER"]	$2y$13$h3FdNa9jtksHRd9Xo8t61OpF1Td3UNsfWTaGGFi.XBECmZWCEAL8W	Norris	Bridgette	43	2023-03-02 20:29:15
24	2	jensen.janiya@gogole.com	["ROLE_USER"]	$2y$13$Td1W4jS6AUz/LxQm7nNa5OP2r4yDzLbE7mtDee6rOjPRChnZnoyWK	Janiya	Jensen	10	2023-03-02 20:29:16
25	1	sydney.sabina@gogole.com	["ROLE_USER"]	$2y$13$V8Q9XLG.vNfxTjY71G3TtOGS4Uybw8NKj5tSuNoSKXBUTuTUoAZNS	Sabina	Sydney	34	2023-03-02 20:29:16
26	1	bessie.keon@gogole.com	["ROLE_USER"]	$2y$13$360AWYv/6eegHK6dMYo2OeHaBZoDFnwHdOcH6WoyJJlSVRt7P791q	Keon	Bessie	64	2023-03-02 20:29:16
27	2	dorian.roosevelt@gogole.com	["ROLE_USER"]	$2y$13$2RKrYZg5VVudx1aQOoBdcexWyjS/crzhIfHT47RGVfCBnNE0Kt88.	Roosevelt	Dorian	63	2023-03-02 20:29:17
28	2	phyllis.antwon@gogole.com	["ROLE_USER"]	$2y$13$BxCWJsv9Oq9ioYDZvWTsyeaYMHJSw7mjLPCm13sDxiVGnEH3bdqZS	Antwon	Phyllis	64	2023-03-02 20:29:17
29	1	ben.heloise@gogole.com	["ROLE_USER"]	$2y$13$XPGvwe5ysbAhPPtIzZLAWOIbHUJvxt805Y7ktwADxknreq3ID5ok6	Heloise	Ben	45	2023-03-02 20:29:18
30	2	martine.sidney@gogole.com	["ROLE_USER"]	$2y$13$Q9TlMAWWeydna9V7SzhVx.v7ZMtkH2BvL0lo.aU.26kroZ1S2p8yK	Sidney	Martine	44	2023-03-02 20:29:19
31	2	kamren.kirstin@gogole.com	["ROLE_USER"]	$2y$13$tSeUnzejkflD4233hPga8.HZp5fFQ5//6KYR7wSMHmpy/xKNLEimS	Kirstin	Kamren	35	2023-03-02 20:29:20
32	1	brennan.lue@gogole.com	["ROLE_USER"]	$2y$13$T5ZCSB1on9R9VUYaw5uYIeIl/WqB9c7yKRZRX2ZtN3sAzS.Nnhh3W	Lue	Brennan	33	2023-03-02 20:29:26
33	1	aurelio.tamara@gogole.com	["ROLE_USER"]	$2y$13$LdDbBL0eCdfz6sHh9q4hmuQHMUZIpIz98zRu1U4RQ1MuPF6fWH0aW	Tamara	Aurelio	17	2023-03-02 20:29:26
34	1	joe.zelda@gogole.com	["ROLE_USER"]	$2y$13$.QnTcEXWcTul0ussA0lBYu1k/2qN0PivPuIJ9Elb2AilHOTb85kmm	Zelda	Joe	21	2023-03-02 20:29:27
35	2	kim.ford@gogole.com	["ROLE_USER"]	$2y$13$qkgu0IsE0rFnp9brw.uBBux9coO2ll66tujZcZx7RnVIvyo6/1FLW	Ford	Kim	15	2023-03-02 20:29:27
36	1	leonardo.abdul@gogole.com	["ROLE_USER"]	$2y$13$CV2qWGoBD7t4Gc8.bd2CI.3rzDcjWC5H0EizJjRqXbAyhbEaToofy	Abdul	Leonardo	65	2023-03-02 20:29:28
37	1	sylvester.loyce@gogole.com	["ROLE_USER"]	$2y$13$d7YqKcPKosgG4cz2xujE4u0zymTlglq1LNmUf8BDra4TZ.9FkkAhW	Loyce	Sylvester	45	2023-03-02 20:29:28
\.


--
-- Data for Name: users_sessions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.users_sessions (sess_id, sess_data, sess_lifetime, sess_time) FROM stdin;
\.


--
-- Name: booking_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.booking_id_seq', 35, true);


--
-- Name: booking_payment_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.booking_payment_id_seq', 35, true);


--
-- Name: booking_ticket_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.booking_ticket_id_seq', 118, true);


--
-- Name: booking_ticket_pricing_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.booking_ticket_pricing_id_seq', 1, false);


--
-- Name: game_room_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.game_room_id_seq', 9, true);


--
-- Name: game_room_session_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.game_room_session_id_seq', 35, true);


--
-- Name: messenger_messages_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.messenger_messages_id_seq', 1, false);


--
-- Name: reference_booking_payment_status_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.reference_booking_payment_status_id_seq', 3, true);


--
-- Name: reference_booking_status_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.reference_booking_status_id_seq', 3, true);


--
-- Name: reference_booking_ticket_pricing_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.reference_booking_ticket_pricing_id_seq', 4, true);


--
-- Name: reference_game_room_theme_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.reference_game_room_theme_id_seq', 9, true);


--
-- Name: reference_people_civility_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.reference_people_civility_id_seq', 3, true);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.users_id_seq', 37, true);


--
-- Name: booking_payment booking_payment_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.booking_payment
    ADD CONSTRAINT booking_payment_pkey PRIMARY KEY (id);


--
-- Name: booking booking_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.booking
    ADD CONSTRAINT booking_pkey PRIMARY KEY (id);


--
-- Name: booking_ticket booking_ticket_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.booking_ticket
    ADD CONSTRAINT booking_ticket_pkey PRIMARY KEY (id);


--
-- Name: booking_ticket_pricing booking_ticket_pricing_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.booking_ticket_pricing
    ADD CONSTRAINT booking_ticket_pricing_pkey PRIMARY KEY (id);


--
-- Name: doctrine_migration_versions doctrine_migration_versions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.doctrine_migration_versions
    ADD CONSTRAINT doctrine_migration_versions_pkey PRIMARY KEY (version);


--
-- Name: game_room game_room_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.game_room
    ADD CONSTRAINT game_room_pkey PRIMARY KEY (id);


--
-- Name: game_room_session game_room_session_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.game_room_session
    ADD CONSTRAINT game_room_session_pkey PRIMARY KEY (id);


--
-- Name: messenger_messages messenger_messages_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.messenger_messages
    ADD CONSTRAINT messenger_messages_pkey PRIMARY KEY (id);


--
-- Name: reference_booking_payment_status reference_booking_payment_status_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.reference_booking_payment_status
    ADD CONSTRAINT reference_booking_payment_status_pkey PRIMARY KEY (id);


--
-- Name: reference_booking_status reference_booking_status_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.reference_booking_status
    ADD CONSTRAINT reference_booking_status_pkey PRIMARY KEY (id);


--
-- Name: reference_booking_ticket_pricing reference_booking_ticket_pricing_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.reference_booking_ticket_pricing
    ADD CONSTRAINT reference_booking_ticket_pricing_pkey PRIMARY KEY (id);


--
-- Name: reference_game_room_theme reference_game_room_theme_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.reference_game_room_theme
    ADD CONSTRAINT reference_game_room_theme_pkey PRIMARY KEY (id);


--
-- Name: reference_people_civility reference_people_civility_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.reference_people_civility
    ADD CONSTRAINT reference_people_civility_pkey PRIMARY KEY (id);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: users_sessions users_sessions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users_sessions
    ADD CONSTRAINT users_sessions_pkey PRIMARY KEY (sess_id);


--
-- Name: idx_1483a5e923d6a298; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_1483a5e923d6a298 ON public.users USING btree (civility_id);


--
-- Name: idx_2c3a965d3301c60; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_2c3a965d3301c60 ON public.booking_ticket USING btree (booking_id);


--
-- Name: idx_2c3a965d7e3c61f9; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_2c3a965d7e3c61f9 ON public.booking_ticket USING btree (owner_id);


--
-- Name: idx_2c3a965ddc7a9a3c; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_2c3a965ddc7a9a3c ON public.booking_ticket USING btree (reference_pricing_id);


--
-- Name: idx_2c3a965de0197dfa; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_2c3a965de0197dfa ON public.booking_ticket USING btree (id_ref_owner_civility);


--
-- Name: idx_3796c12d908c7d2a; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_3796c12d908c7d2a ON public.booking_payment USING btree (id_ref_payment_status);


--
-- Name: idx_75ea56e016ba31db; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_75ea56e016ba31db ON public.messenger_messages USING btree (delivered_at);


--
-- Name: idx_75ea56e0e3bd61ce; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_75ea56e0e3bd61ce ON public.messenger_messages USING btree (available_at);


--
-- Name: idx_75ea56e0fb7336f0; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_75ea56e0fb7336f0 ON public.messenger_messages USING btree (queue_name);


--
-- Name: idx_998a3db759027487; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_998a3db759027487 ON public.game_room USING btree (theme_id);


--
-- Name: idx_d2b65d5a19bf8190; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_d2b65d5a19bf8190 ON public.game_room_session USING btree (id_game_room);


--
-- Name: idx_e00cedde4c3a3bb; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_e00cedde4c3a3bb ON public.booking USING btree (payment_id);


--
-- Name: idx_e00cedde613fecdf; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_e00cedde613fecdf ON public.booking USING btree (session_id);


--
-- Name: idx_e00cedde9395c3f3; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_e00cedde9395c3f3 ON public.booking USING btree (customer_id);


--
-- Name: idx_e00ceddeab938d32; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_e00ceddeab938d32 ON public.booking USING btree (id_ref_status);


--
-- Name: sessions_sess_lifetime_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX sessions_sess_lifetime_idx ON public.users_sessions USING btree (sess_lifetime);


--
-- Name: uniq_1483a5e9e7927c74; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX uniq_1483a5e9e7927c74 ON public.users USING btree (email);


--
-- Name: uniq_72520e9139f73214; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX uniq_72520e9139f73214 ON public.booking_ticket_pricing USING btree (id_ref_pricing);


--
-- Name: messenger_messages notify_trigger; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON public.messenger_messages FOR EACH ROW EXECUTE FUNCTION public.notify_messenger_messages();


--
-- Name: users fk_1483a5e923d6a298; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT fk_1483a5e923d6a298 FOREIGN KEY (civility_id) REFERENCES public.reference_people_civility(id);


--
-- Name: booking_ticket fk_2c3a965d3301c60; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.booking_ticket
    ADD CONSTRAINT fk_2c3a965d3301c60 FOREIGN KEY (booking_id) REFERENCES public.booking(id);


--
-- Name: booking_ticket fk_2c3a965d7e3c61f9; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.booking_ticket
    ADD CONSTRAINT fk_2c3a965d7e3c61f9 FOREIGN KEY (owner_id) REFERENCES public.users(id);


--
-- Name: booking_ticket fk_2c3a965ddc7a9a3c; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.booking_ticket
    ADD CONSTRAINT fk_2c3a965ddc7a9a3c FOREIGN KEY (reference_pricing_id) REFERENCES public.reference_booking_ticket_pricing(id);


--
-- Name: booking_ticket fk_2c3a965de0197dfa; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.booking_ticket
    ADD CONSTRAINT fk_2c3a965de0197dfa FOREIGN KEY (id_ref_owner_civility) REFERENCES public.reference_people_civility(id);


--
-- Name: booking_payment fk_3796c12d908c7d2a; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.booking_payment
    ADD CONSTRAINT fk_3796c12d908c7d2a FOREIGN KEY (id_ref_payment_status) REFERENCES public.reference_booking_payment_status(id);


--
-- Name: booking_ticket_pricing fk_72520e9139f73214; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.booking_ticket_pricing
    ADD CONSTRAINT fk_72520e9139f73214 FOREIGN KEY (id_ref_pricing) REFERENCES public.reference_booking_ticket_pricing(id);


--
-- Name: game_room fk_998a3db759027487; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.game_room
    ADD CONSTRAINT fk_998a3db759027487 FOREIGN KEY (theme_id) REFERENCES public.reference_game_room_theme(id);


--
-- Name: game_room_session fk_d2b65d5a19bf8190; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.game_room_session
    ADD CONSTRAINT fk_d2b65d5a19bf8190 FOREIGN KEY (id_game_room) REFERENCES public.game_room(id);


--
-- Name: booking fk_e00cedde4c3a3bb; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.booking
    ADD CONSTRAINT fk_e00cedde4c3a3bb FOREIGN KEY (payment_id) REFERENCES public.booking_payment(id);


--
-- Name: booking fk_e00cedde613fecdf; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.booking
    ADD CONSTRAINT fk_e00cedde613fecdf FOREIGN KEY (session_id) REFERENCES public.game_room_session(id);


--
-- Name: booking fk_e00cedde9395c3f3; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.booking
    ADD CONSTRAINT fk_e00cedde9395c3f3 FOREIGN KEY (customer_id) REFERENCES public.users(id);


--
-- Name: booking fk_e00ceddeab938d32; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.booking
    ADD CONSTRAINT fk_e00ceddeab938d32 FOREIGN KEY (id_ref_status) REFERENCES public.reference_booking_status(id);


--
-- PostgreSQL database dump complete
--

