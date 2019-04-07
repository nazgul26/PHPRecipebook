<<<<<<< Updated upstream
--
-- PostgreSQL database dump
--

-- Dumped from database version 11.2
-- Dumped by pg_dump version 11.2

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: attachments; Type: TABLE; Schema: public; Owner: recipebook
--

CREATE TABLE public.attachments (
    id integer NOT NULL,
    recipe_id integer NOT NULL,
    name character varying(32) NOT NULL,
    attachment character varying(255) NOT NULL,
    dir character varying(255) DEFAULT NULL::character varying,
    type character varying(255) DEFAULT NULL::character varying,
    size integer DEFAULT 0,
    sort_order integer
);


ALTER TABLE public.attachments OWNER TO recipebook;

--
-- Name: attachments_id_seq; Type: SEQUENCE; Schema: public; Owner: recipebook
--

CREATE SEQUENCE public.attachments_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.attachments_id_seq OWNER TO recipebook;

--
-- Name: attachments_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: recipebook
--

ALTER SEQUENCE public.attachments_id_seq OWNED BY public.attachments.id;


--
-- Name: base_types; Type: TABLE; Schema: public; Owner: recipebook
--

CREATE TABLE public.base_types (
    id integer NOT NULL,
    name character varying(64) NOT NULL
);


ALTER TABLE public.base_types OWNER TO recipebook;

--
-- Name: base_types_id_seq; Type: SEQUENCE; Schema: public; Owner: recipebook
--

CREATE SEQUENCE public.base_types_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.base_types_id_seq OWNER TO recipebook;

--
-- Name: base_types_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: recipebook
--

ALTER SEQUENCE public.base_types_id_seq OWNED BY public.base_types.id;


--
-- Name: courses; Type: TABLE; Schema: public; Owner: recipebook
--

CREATE TABLE public.courses (
    id integer NOT NULL,
    name character varying(64) NOT NULL
);


ALTER TABLE public.courses OWNER TO recipebook;

--
-- Name: courses_id_seq; Type: SEQUENCE; Schema: public; Owner: recipebook
--

CREATE SEQUENCE public.courses_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.courses_id_seq OWNER TO recipebook;

--
-- Name: courses_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: recipebook
--

ALTER SEQUENCE public.courses_id_seq OWNED BY public.courses.id;


--
-- Name: difficulties; Type: TABLE; Schema: public; Owner: recipebook
--

CREATE TABLE public.difficulties (
    id integer NOT NULL,
    name character varying(64) DEFAULT NULL::character varying
);


ALTER TABLE public.difficulties OWNER TO recipebook;

--
-- Name: difficulties_id_seq; Type: SEQUENCE; Schema: public; Owner: recipebook
--

CREATE SEQUENCE public.difficulties_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.difficulties_id_seq OWNER TO recipebook;

--
-- Name: difficulties_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: recipebook
--

ALTER SEQUENCE public.difficulties_id_seq OWNED BY public.difficulties.id;


--
-- Name: ethnicities; Type: TABLE; Schema: public; Owner: recipebook
--

CREATE TABLE public.ethnicities (
    id integer NOT NULL,
    name character varying(64) NOT NULL
);


ALTER TABLE public.ethnicities OWNER TO recipebook;

--
-- Name: ethnicities_id_seq; Type: SEQUENCE; Schema: public; Owner: recipebook
--

CREATE SEQUENCE public.ethnicities_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.ethnicities_id_seq OWNER TO recipebook;

--
-- Name: ethnicities_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: recipebook
--

ALTER SEQUENCE public.ethnicities_id_seq OWNED BY public.ethnicities.id;


--
-- Name: ingredient_mappings; Type: TABLE; Schema: public; Owner: recipebook
--

CREATE TABLE public.ingredient_mappings (
    recipe_id integer NOT NULL,
    ingredient_id integer NOT NULL,
    quantity double precision NOT NULL,
    unit_id integer,
    qualifier character varying(32) DEFAULT NULL::character varying,
    note character varying(255) DEFAULT NULL::character varying,
    optional boolean,
    sort_order integer,
    id integer NOT NULL
);


ALTER TABLE public.ingredient_mappings OWNER TO recipebook;

--
-- Name: ingredient_mappings_id_seq; Type: SEQUENCE; Schema: public; Owner: recipebook
--

CREATE SEQUENCE public.ingredient_mappings_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.ingredient_mappings_id_seq OWNER TO recipebook;

--
-- Name: ingredient_mappings_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: recipebook
--

ALTER SEQUENCE public.ingredient_mappings_id_seq OWNED BY public.ingredient_mappings.id;


--
-- Name: ingredients; Type: TABLE; Schema: public; Owner: recipebook
--

CREATE TABLE public.ingredients (
    id integer NOT NULL,
    name character varying(120) NOT NULL,
    description text,
    location_id integer,
    unit_id integer,
    solid boolean,
    system character varying(8) DEFAULT 'usa'::character varying,
    user_id integer
);


ALTER TABLE public.ingredients OWNER TO recipebook;

--
-- Name: ingredients_id_seq; Type: SEQUENCE; Schema: public; Owner: recipebook
--

CREATE SEQUENCE public.ingredients_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.ingredients_id_seq OWNER TO recipebook;

--
-- Name: ingredients_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: recipebook
--

ALTER SEQUENCE public.ingredients_id_seq OWNED BY public.ingredients.id;


--
-- Name: locations; Type: TABLE; Schema: public; Owner: recipebook
--

CREATE TABLE public.locations (
    id integer NOT NULL,
    name character varying(64) NOT NULL
);


ALTER TABLE public.locations OWNER TO recipebook;

--
-- Name: locations_id_seq; Type: SEQUENCE; Schema: public; Owner: recipebook
--

CREATE SEQUENCE public.locations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.locations_id_seq OWNER TO recipebook;

--
-- Name: locations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: recipebook
--

ALTER SEQUENCE public.locations_id_seq OWNED BY public.locations.id;


--
-- Name: meal_names; Type: TABLE; Schema: public; Owner: recipebook
--

CREATE TABLE public.meal_names (
    id integer NOT NULL,
    name character varying(64) NOT NULL
);


ALTER TABLE public.meal_names OWNER TO recipebook;

--
-- Name: meal_names_id_seq; Type: SEQUENCE; Schema: public; Owner: recipebook
--

CREATE SEQUENCE public.meal_names_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.meal_names_id_seq OWNER TO recipebook;

--
-- Name: meal_names_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: recipebook
--

ALTER SEQUENCE public.meal_names_id_seq OWNED BY public.meal_names.id;


--
-- Name: meal_plans; Type: TABLE; Schema: public; Owner: recipebook
--

CREATE TABLE public.meal_plans (
    mealday date NOT NULL,
    meal_name_id integer NOT NULL,
    recipe_id integer NOT NULL,
    servings integer DEFAULT 0 NOT NULL,
    user_id integer,
    id integer NOT NULL
);


ALTER TABLE public.meal_plans OWNER TO recipebook;

--
-- Name: meal_plans_id_seq; Type: SEQUENCE; Schema: public; Owner: recipebook
--

CREATE SEQUENCE public.meal_plans_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.meal_plans_id_seq OWNER TO recipebook;

--
-- Name: meal_plans_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: recipebook
--

ALTER SEQUENCE public.meal_plans_id_seq OWNED BY public.meal_plans.id;


--
-- Name: preparation_methods; Type: TABLE; Schema: public; Owner: recipebook
--

CREATE TABLE public.preparation_methods (
    id integer NOT NULL,
    name character varying(64) DEFAULT NULL::character varying
);


ALTER TABLE public.preparation_methods OWNER TO recipebook;

--
-- Name: preparation_methods_id_seq; Type: SEQUENCE; Schema: public; Owner: recipebook
--

CREATE SEQUENCE public.preparation_methods_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.preparation_methods_id_seq OWNER TO recipebook;

--
-- Name: preparation_methods_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: recipebook
--

ALTER SEQUENCE public.preparation_methods_id_seq OWNED BY public.preparation_methods.id;


--
-- Name: preparation_times; Type: TABLE; Schema: public; Owner: recipebook
--

CREATE TABLE public.preparation_times (
    id integer NOT NULL,
    name character varying(64) NOT NULL
);


ALTER TABLE public.preparation_times OWNER TO recipebook;

--
-- Name: preparation_times_id_seq; Type: SEQUENCE; Schema: public; Owner: recipebook
--

CREATE SEQUENCE public.preparation_times_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.preparation_times_id_seq OWNER TO recipebook;

--
-- Name: preparation_times_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: recipebook
--

ALTER SEQUENCE public.preparation_times_id_seq OWNED BY public.preparation_times.id;


--
-- Name: price_ranges; Type: TABLE; Schema: public; Owner: recipebook
--

CREATE TABLE public.price_ranges (
    id integer NOT NULL,
    name character varying(16) DEFAULT NULL::character varying
);


ALTER TABLE public.price_ranges OWNER TO recipebook;

--
-- Name: price_ranges_id_seq; Type: SEQUENCE; Schema: public; Owner: recipebook
--

CREATE SEQUENCE public.price_ranges_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.price_ranges_id_seq OWNER TO recipebook;

--
-- Name: price_ranges_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: recipebook
--

ALTER SEQUENCE public.price_ranges_id_seq OWNED BY public.price_ranges.id;


--
-- Name: recipes; Type: TABLE; Schema: public; Owner: recipebook
--

CREATE TABLE public.recipes (
    id integer NOT NULL,
    name character varying(128) NOT NULL,
    ethnicity_id integer,
    base_type_id integer,
    course_id integer,
    preparation_time_id integer,
    difficulty_id integer,
    serving_size integer,
    directions text,
    comments text,
    source_description character varying(200) DEFAULT NULL::character varying,
    recipe_cost double precision,
    modified date,
    picture bytea,
    picture_type character varying(32) DEFAULT NULL::character varying,
    private boolean NOT NULL,
    system character varying(16) DEFAULT 'usa'::character varying NOT NULL,
    source_id integer,
    user_id integer,
    preparation_method_id integer
);


ALTER TABLE public.recipes OWNER TO recipebook;

--
-- Name: recipes_id_seq; Type: SEQUENCE; Schema: public; Owner: recipebook
--

CREATE SEQUENCE public.recipes_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.recipes_id_seq OWNER TO recipebook;

--
-- Name: recipes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: recipebook
--

ALTER SEQUENCE public.recipes_id_seq OWNED BY public.recipes.id;


--
-- Name: related_recipes; Type: TABLE; Schema: public; Owner: recipebook
--

CREATE TABLE public.related_recipes (
    parent_id integer NOT NULL,
    recipe_id integer NOT NULL,
    required boolean,
    sort_order integer,
    id integer NOT NULL
);


ALTER TABLE public.related_recipes OWNER TO recipebook;

--
-- Name: related_recipes_id_seq; Type: SEQUENCE; Schema: public; Owner: recipebook
--

CREATE SEQUENCE public.related_recipes_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.related_recipes_id_seq OWNER TO recipebook;

--
-- Name: related_recipes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: recipebook
--

ALTER SEQUENCE public.related_recipes_id_seq OWNED BY public.related_recipes.id;


--
-- Name: restaurants; Type: TABLE; Schema: public; Owner: recipebook
--

CREATE TABLE public.restaurants (
    id integer NOT NULL,
    name character varying(64) NOT NULL,
    street character varying(128) DEFAULT NULL::character varying,
    city character varying(64) DEFAULT NULL::character varying,
    state character varying(2) DEFAULT NULL::character varying,
    zip character varying(16) DEFAULT NULL::character varying,
    phone character varying(128) DEFAULT NULL::character varying,
    hours text,
    picture bytea,
    picture_type character varying(64) DEFAULT NULL::character varying,
    menu_text text,
    comments text,
    price_range_id integer,
    delivery boolean,
    carry_out boolean,
    dine_in boolean,
    credit boolean,
    user_id integer,
    website character varying(254) DEFAULT NULL::character varying,
    country character varying(64) DEFAULT NULL::character varying
);


ALTER TABLE public.restaurants OWNER TO recipebook;

--
-- Name: restaurants_id_seq; Type: SEQUENCE; Schema: public; Owner: recipebook
--

CREATE SEQUENCE public.restaurants_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.restaurants_id_seq OWNER TO recipebook;

--
-- Name: restaurants_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: recipebook
--

ALTER SEQUENCE public.restaurants_id_seq OWNED BY public.restaurants.id;


--
-- Name: reviews; Type: TABLE; Schema: public; Owner: recipebook
--

CREATE TABLE public.reviews (
    recipe_id integer NOT NULL,
    comments character varying(255) NOT NULL,
    created timestamp without time zone,
    user_id integer,
    id integer NOT NULL,
    rating integer
);


ALTER TABLE public.reviews OWNER TO recipebook;

--
-- Name: reviews_id_seq; Type: SEQUENCE; Schema: public; Owner: recipebook
--

CREATE SEQUENCE public.reviews_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.reviews_id_seq OWNER TO recipebook;

--
-- Name: reviews_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: recipebook
--

ALTER SEQUENCE public.reviews_id_seq OWNED BY public.reviews.id;


--
-- Name: shopping_list_ingredients; Type: TABLE; Schema: public; Owner: recipebook
--

CREATE TABLE public.shopping_list_ingredients (
    id integer NOT NULL,
    shopping_list_id integer NOT NULL,
    ingredient_id integer NOT NULL,
    unit_id integer NOT NULL,
    qualifier character varying(32) DEFAULT NULL::character varying,
    quantity double precision NOT NULL,
    user_id integer
);


ALTER TABLE public.shopping_list_ingredients OWNER TO recipebook;

--
-- Name: shopping_list_ingredients_id_seq; Type: SEQUENCE; Schema: public; Owner: recipebook
--

CREATE SEQUENCE public.shopping_list_ingredients_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.shopping_list_ingredients_id_seq OWNER TO recipebook;

--
-- Name: shopping_list_ingredients_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: recipebook
--

ALTER SEQUENCE public.shopping_list_ingredients_id_seq OWNED BY public.shopping_list_ingredients.id;


--
-- Name: shopping_list_recipes; Type: TABLE; Schema: public; Owner: recipebook
--

CREATE TABLE public.shopping_list_recipes (
    id integer NOT NULL,
    shopping_list_id integer NOT NULL,
    recipe_id integer NOT NULL,
    servings integer DEFAULT 1,
    user_id integer
);


ALTER TABLE public.shopping_list_recipes OWNER TO recipebook;

--
-- Name: shopping_list_recipes_id_seq; Type: SEQUENCE; Schema: public; Owner: recipebook
--

CREATE SEQUENCE public.shopping_list_recipes_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.shopping_list_recipes_id_seq OWNER TO recipebook;

--
-- Name: shopping_list_recipes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: recipebook
--

ALTER SEQUENCE public.shopping_list_recipes_id_seq OWNED BY public.shopping_list_recipes.id;


--
-- Name: shopping_lists; Type: TABLE; Schema: public; Owner: recipebook
--

CREATE TABLE public.shopping_lists (
    id integer NOT NULL,
    name character varying(64) NOT NULL,
    user_id integer
);


ALTER TABLE public.shopping_lists OWNER TO recipebook;

--
-- Name: shopping_lists_id_seq; Type: SEQUENCE; Schema: public; Owner: recipebook
--

CREATE SEQUENCE public.shopping_lists_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.shopping_lists_id_seq OWNER TO recipebook;

--
-- Name: shopping_lists_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: recipebook
--

ALTER SEQUENCE public.shopping_lists_id_seq OWNED BY public.shopping_lists.id;


--
-- Name: sources; Type: TABLE; Schema: public; Owner: recipebook
--

CREATE TABLE public.sources (
    id integer NOT NULL,
    name character varying(64) DEFAULT NULL::character varying,
    description text,
    user_id integer
);


ALTER TABLE public.sources OWNER TO recipebook;

--
-- Name: sources_id_seq; Type: SEQUENCE; Schema: public; Owner: recipebook
--

CREATE SEQUENCE public.sources_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sources_id_seq OWNER TO recipebook;

--
-- Name: sources_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: recipebook
--

ALTER SEQUENCE public.sources_id_seq OWNED BY public.sources.id;


--
-- Name: stores; Type: TABLE; Schema: public; Owner: recipebook
--

CREATE TABLE public.stores (
    name character varying(32) NOT NULL,
    layout text,
    id integer NOT NULL
);


ALTER TABLE public.stores OWNER TO recipebook;

--
-- Name: stores_id_seq; Type: SEQUENCE; Schema: public; Owner: recipebook
--

CREATE SEQUENCE public.stores_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.stores_id_seq OWNER TO recipebook;

--
-- Name: stores_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: recipebook
--

ALTER SEQUENCE public.stores_id_seq OWNED BY public.stores.id;


--
-- Name: units; Type: TABLE; Schema: public; Owner: recipebook
--

CREATE TABLE public.units (
    id integer NOT NULL,
    name character varying(64) NOT NULL,
    abbreviation character varying(8) NOT NULL,
    system integer NOT NULL,
    sort_order integer NOT NULL
);


ALTER TABLE public.units OWNER TO recipebook;

--
-- Name: units_id_seq; Type: SEQUENCE; Schema: public; Owner: recipebook
--

CREATE SEQUENCE public.units_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.units_id_seq OWNER TO recipebook;

--
-- Name: units_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: recipebook
--

ALTER SEQUENCE public.units_id_seq OWNED BY public.units.id;


--
-- Name: users; Type: TABLE; Schema: public; Owner: recipebook
--

CREATE TABLE public.users (
    username character varying(32) NOT NULL,
    password character varying(255) NOT NULL,
    name character varying(64) NOT NULL,
    access_level integer DEFAULT 0 NOT NULL,
    language character varying(8) DEFAULT 'en'::character varying NOT NULL,
    country character varying(8) DEFAULT 'us'::character varying NOT NULL,
    created timestamp without time zone,
    last_login timestamp without time zone,
    email character varying(64) NOT NULL,
    id integer NOT NULL,
    modified timestamp without time zone,
    reset_token character varying(255) DEFAULT NULL::character varying,
    locked boolean DEFAULT false NOT NULL,
    reset_time timestamp without time zone,
    meal_plan_start_day integer DEFAULT 0 NOT NULL
);


ALTER TABLE public.users OWNER TO recipebook;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: recipebook
--

CREATE SEQUENCE public.users_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.users_id_seq OWNER TO recipebook;

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: recipebook
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- Name: vendor_products; Type: TABLE; Schema: public; Owner: recipebook
--

CREATE TABLE public.vendor_products (
    id integer NOT NULL,
    ingredient_id integer NOT NULL,
    vendor_id integer NOT NULL,
    code character varying(32) DEFAULT NULL::character varying,
    user_id integer,
    name character varying(255) DEFAULT NULL::character varying
);


ALTER TABLE public.vendor_products OWNER TO recipebook;

--
-- Name: vendor_products_id_seq; Type: SEQUENCE; Schema: public; Owner: recipebook
--

CREATE SEQUENCE public.vendor_products_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.vendor_products_id_seq OWNER TO recipebook;

--
-- Name: vendor_products_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: recipebook
--

ALTER SEQUENCE public.vendor_products_id_seq OWNED BY public.vendor_products.id;


--
-- Name: vendors; Type: TABLE; Schema: public; Owner: recipebook
--

CREATE TABLE public.vendors (
    id integer NOT NULL,
    name character varying(64) NOT NULL,
    home_url character varying(255) DEFAULT NULL::character varying,
    add_url character varying(255) DEFAULT NULL::character varying,
    request_type character varying(10) DEFAULT 'GET'::character varying,
    format character varying(255) DEFAULT NULL::character varying
);


ALTER TABLE public.vendors OWNER TO recipebook;

--
-- Name: vendors_id_seq; Type: SEQUENCE; Schema: public; Owner: recipebook
--

CREATE SEQUENCE public.vendors_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.vendors_id_seq OWNER TO recipebook;

--
-- Name: vendors_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: recipebook
--

ALTER SEQUENCE public.vendors_id_seq OWNED BY public.vendors.id;


--
-- Name: attachments id; Type: DEFAULT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.attachments ALTER COLUMN id SET DEFAULT nextval('public.attachments_id_seq'::regclass);


--
-- Name: base_types id; Type: DEFAULT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.base_types ALTER COLUMN id SET DEFAULT nextval('public.base_types_id_seq'::regclass);


--
-- Name: courses id; Type: DEFAULT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.courses ALTER COLUMN id SET DEFAULT nextval('public.courses_id_seq'::regclass);


--
-- Name: difficulties id; Type: DEFAULT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.difficulties ALTER COLUMN id SET DEFAULT nextval('public.difficulties_id_seq'::regclass);


--
-- Name: ethnicities id; Type: DEFAULT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.ethnicities ALTER COLUMN id SET DEFAULT nextval('public.ethnicities_id_seq'::regclass);


--
-- Name: ingredient_mappings id; Type: DEFAULT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.ingredient_mappings ALTER COLUMN id SET DEFAULT nextval('public.ingredient_mappings_id_seq'::regclass);


--
-- Name: ingredients id; Type: DEFAULT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.ingredients ALTER COLUMN id SET DEFAULT nextval('public.ingredients_id_seq'::regclass);


--
-- Name: locations id; Type: DEFAULT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.locations ALTER COLUMN id SET DEFAULT nextval('public.locations_id_seq'::regclass);


--
-- Name: meal_names id; Type: DEFAULT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.meal_names ALTER COLUMN id SET DEFAULT nextval('public.meal_names_id_seq'::regclass);


--
-- Name: meal_plans id; Type: DEFAULT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.meal_plans ALTER COLUMN id SET DEFAULT nextval('public.meal_plans_id_seq'::regclass);


--
-- Name: preparation_methods id; Type: DEFAULT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.preparation_methods ALTER COLUMN id SET DEFAULT nextval('public.preparation_methods_id_seq'::regclass);


--
-- Name: preparation_times id; Type: DEFAULT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.preparation_times ALTER COLUMN id SET DEFAULT nextval('public.preparation_times_id_seq'::regclass);


--
-- Name: price_ranges id; Type: DEFAULT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.price_ranges ALTER COLUMN id SET DEFAULT nextval('public.price_ranges_id_seq'::regclass);


--
-- Name: recipes id; Type: DEFAULT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.recipes ALTER COLUMN id SET DEFAULT nextval('public.recipes_id_seq'::regclass);


--
-- Name: related_recipes id; Type: DEFAULT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.related_recipes ALTER COLUMN id SET DEFAULT nextval('public.related_recipes_id_seq'::regclass);


--
-- Name: restaurants id; Type: DEFAULT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.restaurants ALTER COLUMN id SET DEFAULT nextval('public.restaurants_id_seq'::regclass);


--
-- Name: reviews id; Type: DEFAULT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.reviews ALTER COLUMN id SET DEFAULT nextval('public.reviews_id_seq'::regclass);


--
-- Name: shopping_list_ingredients id; Type: DEFAULT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.shopping_list_ingredients ALTER COLUMN id SET DEFAULT nextval('public.shopping_list_ingredients_id_seq'::regclass);


--
-- Name: shopping_list_recipes id; Type: DEFAULT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.shopping_list_recipes ALTER COLUMN id SET DEFAULT nextval('public.shopping_list_recipes_id_seq'::regclass);


--
-- Name: shopping_lists id; Type: DEFAULT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.shopping_lists ALTER COLUMN id SET DEFAULT nextval('public.shopping_lists_id_seq'::regclass);


--
-- Name: sources id; Type: DEFAULT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.sources ALTER COLUMN id SET DEFAULT nextval('public.sources_id_seq'::regclass);


--
-- Name: stores id; Type: DEFAULT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.stores ALTER COLUMN id SET DEFAULT nextval('public.stores_id_seq'::regclass);


--
-- Name: units id; Type: DEFAULT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.units ALTER COLUMN id SET DEFAULT nextval('public.units_id_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Name: vendor_products id; Type: DEFAULT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.vendor_products ALTER COLUMN id SET DEFAULT nextval('public.vendor_products_id_seq'::regclass);


--
-- Name: vendors id; Type: DEFAULT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.vendors ALTER COLUMN id SET DEFAULT nextval('public.vendors_id_seq'::regclass);


--
-- Name: attachments attachments_pkey; Type: CONSTRAINT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.attachments
    ADD CONSTRAINT attachments_pkey PRIMARY KEY (id);


--
-- Name: base_types base_types_pkey; Type: CONSTRAINT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.base_types
    ADD CONSTRAINT base_types_pkey PRIMARY KEY (id);


--
-- Name: courses courses_pkey; Type: CONSTRAINT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.courses
    ADD CONSTRAINT courses_pkey PRIMARY KEY (id);


--
-- Name: difficulties difficulties_pkey; Type: CONSTRAINT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.difficulties
    ADD CONSTRAINT difficulties_pkey PRIMARY KEY (id);


--
-- Name: ethnicities ethnicities_pkey; Type: CONSTRAINT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.ethnicities
    ADD CONSTRAINT ethnicities_pkey PRIMARY KEY (id);


--
-- Name: ingredient_mappings ingredient_mappings_pkey; Type: CONSTRAINT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.ingredient_mappings
    ADD CONSTRAINT ingredient_mappings_pkey PRIMARY KEY (id);


--
-- Name: ingredients ingredients_pkey; Type: CONSTRAINT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.ingredients
    ADD CONSTRAINT ingredients_pkey PRIMARY KEY (id);


--
-- Name: locations locations_pkey; Type: CONSTRAINT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.locations
    ADD CONSTRAINT locations_pkey PRIMARY KEY (id);


--
-- Name: meal_names meal_names_pkey; Type: CONSTRAINT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.meal_names
    ADD CONSTRAINT meal_names_pkey PRIMARY KEY (id);


--
-- Name: meal_plans meal_plans_pkey; Type: CONSTRAINT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.meal_plans
    ADD CONSTRAINT meal_plans_pkey PRIMARY KEY (id);


--
-- Name: preparation_methods preparation_methods_pkey; Type: CONSTRAINT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.preparation_methods
    ADD CONSTRAINT preparation_methods_pkey PRIMARY KEY (id);


--
-- Name: preparation_times preparation_times_pkey; Type: CONSTRAINT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.preparation_times
    ADD CONSTRAINT preparation_times_pkey PRIMARY KEY (id);


--
-- Name: price_ranges price_ranges_pkey; Type: CONSTRAINT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.price_ranges
    ADD CONSTRAINT price_ranges_pkey PRIMARY KEY (id);


--
-- Name: recipes recipes_pkey; Type: CONSTRAINT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.recipes
    ADD CONSTRAINT recipes_pkey PRIMARY KEY (id);


--
-- Name: related_recipes related_recipes_pkey; Type: CONSTRAINT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.related_recipes
    ADD CONSTRAINT related_recipes_pkey PRIMARY KEY (id);


--
-- Name: restaurants restaurants_pkey; Type: CONSTRAINT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.restaurants
    ADD CONSTRAINT restaurants_pkey PRIMARY KEY (id);


--
-- Name: reviews reviews_pkey; Type: CONSTRAINT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.reviews
    ADD CONSTRAINT reviews_pkey PRIMARY KEY (id);


--
-- Name: shopping_list_ingredients shopping_list_ingredients_pkey; Type: CONSTRAINT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.shopping_list_ingredients
    ADD CONSTRAINT shopping_list_ingredients_pkey PRIMARY KEY (id);


--
-- Name: shopping_list_recipes shopping_list_recipes_pkey; Type: CONSTRAINT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.shopping_list_recipes
    ADD CONSTRAINT shopping_list_recipes_pkey PRIMARY KEY (id);


--
-- Name: shopping_lists shopping_lists_pkey; Type: CONSTRAINT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.shopping_lists
    ADD CONSTRAINT shopping_lists_pkey PRIMARY KEY (id);


--
-- Name: sources sources_pkey; Type: CONSTRAINT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.sources
    ADD CONSTRAINT sources_pkey PRIMARY KEY (id);


--
-- Name: stores stores_pkey; Type: CONSTRAINT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.stores
    ADD CONSTRAINT stores_pkey PRIMARY KEY (id);


--
-- Name: units units_pkey; Type: CONSTRAINT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.units
    ADD CONSTRAINT units_pkey PRIMARY KEY (id);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: vendor_products vendor_products_pkey; Type: CONSTRAINT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.vendor_products
    ADD CONSTRAINT vendor_products_pkey PRIMARY KEY (id);


--
-- Name: vendors vendors_pkey; Type: CONSTRAINT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.vendors
    ADD CONSTRAINT vendors_pkey PRIMARY KEY (id);


--
-- Name: email; Type: INDEX; Schema: public; Owner: recipebook
--

CREATE UNIQUE INDEX email ON public.users USING btree (email);


--
-- Name: meal_name; Type: INDEX; Schema: public; Owner: recipebook
--

CREATE UNIQUE INDEX meal_name ON public.meal_names USING btree (name);


--
-- Name: mealday; Type: INDEX; Schema: public; Owner: recipebook
--

CREATE UNIQUE INDEX mealday ON public.meal_plans USING btree (mealday, meal_name_id, recipe_id, user_id);


--
-- Name: name; Type: INDEX; Schema: public; Owner: recipebook
--

CREATE UNIQUE INDEX name ON public.base_types USING btree (name);


--
-- Name: recipe_id; Type: INDEX; Schema: public; Owner: recipebook
--

CREATE UNIQUE INDEX recipe_id ON public.reviews USING btree (recipe_id, user_id);


--
-- Name: user_email; Type: INDEX; Schema: public; Owner: recipebook
--

CREATE UNIQUE INDEX user_email ON public.users USING btree (email);


--
-- Name: user_login; Type: INDEX; Schema: public; Owner: recipebook
--

CREATE UNIQUE INDEX user_login ON public.users USING btree (username);


--
-- Name: username; Type: INDEX; Schema: public; Owner: recipebook
--

CREATE UNIQUE INDEX username ON public.users USING btree (username);


--
-- PostgreSQL database dump complete
--

=======
--
-- PostgreSQL database dump
--

-- Dumped from database version 11.2
-- Dumped by pg_dump version 11.2

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: attachments; Type: TABLE; Schema: public; Owner: recipebook
--

CREATE TABLE public.attachments (
    id integer NOT NULL,
    recipe_id integer NOT NULL,
    name character varying(32) NOT NULL,
    attachment character varying(255) NOT NULL,
    dir character varying(255) DEFAULT NULL::character varying,
    type character varying(255) DEFAULT NULL::character varying,
    size integer DEFAULT 0,
    sort_order integer
);



--
-- Name: attachments_id_seq; Type: SEQUENCE; Schema: public; Owner: recipebook
--

CREATE SEQUENCE public.attachments_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: attachments_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: recipebook
--

ALTER SEQUENCE public.attachments_id_seq OWNED BY public.attachments.id;


--
-- Name: base_types; Type: TABLE; Schema: public; Owner: recipebook
--

CREATE TABLE public.base_types (
    id integer NOT NULL,
    name character varying(64) NOT NULL
);



--
-- Name: base_types_id_seq; Type: SEQUENCE; Schema: public; Owner: recipebook
--

CREATE SEQUENCE public.base_types_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: base_types_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: recipebook
--

ALTER SEQUENCE public.base_types_id_seq OWNED BY public.base_types.id;


--
-- Name: courses; Type: TABLE; Schema: public; Owner: recipebook
--

CREATE TABLE public.courses (
    id integer NOT NULL,
    name character varying(64) NOT NULL
);



--
-- Name: courses_id_seq; Type: SEQUENCE; Schema: public; Owner: recipebook
--

CREATE SEQUENCE public.courses_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: courses_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: recipebook
--

ALTER SEQUENCE public.courses_id_seq OWNED BY public.courses.id;


--
-- Name: difficulties; Type: TABLE; Schema: public; Owner: recipebook
--

CREATE TABLE public.difficulties (
    id integer NOT NULL,
    name character varying(64) DEFAULT NULL::character varying
);



--
-- Name: difficulties_id_seq; Type: SEQUENCE; Schema: public; Owner: recipebook
--

CREATE SEQUENCE public.difficulties_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: difficulties_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: recipebook
--

ALTER SEQUENCE public.difficulties_id_seq OWNED BY public.difficulties.id;


--
-- Name: ethnicities; Type: TABLE; Schema: public; Owner: recipebook
--

CREATE TABLE public.ethnicities (
    id integer NOT NULL,
    name character varying(64) NOT NULL
);



--
-- Name: ethnicities_id_seq; Type: SEQUENCE; Schema: public; Owner: recipebook
--

CREATE SEQUENCE public.ethnicities_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: ethnicities_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: recipebook
--

ALTER SEQUENCE public.ethnicities_id_seq OWNED BY public.ethnicities.id;


--
-- Name: ingredient_mappings; Type: TABLE; Schema: public; Owner: recipebook
--

CREATE TABLE public.ingredient_mappings (
    recipe_id integer NOT NULL,
    ingredient_id integer NOT NULL,
    quantity double precision NOT NULL,
    unit_id integer,
    qualifier character varying(32) DEFAULT NULL::character varying,
    note character varying(255) DEFAULT NULL::character varying,
    optional boolean,
    sort_order integer,
    id integer NOT NULL
);



--
-- Name: ingredient_mappings_id_seq; Type: SEQUENCE; Schema: public; Owner: recipebook
--

CREATE SEQUENCE public.ingredient_mappings_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: ingredient_mappings_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: recipebook
--

ALTER SEQUENCE public.ingredient_mappings_id_seq OWNED BY public.ingredient_mappings.id;


--
-- Name: ingredients; Type: TABLE; Schema: public; Owner: recipebook
--

CREATE TABLE public.ingredients (
    id integer NOT NULL,
    name character varying(120) NOT NULL,
    description text,
    location_id integer,
    unit_id integer,
    solid boolean,
    system character varying(8) DEFAULT 'usa'::character varying,
    user_id integer
);



--
-- Name: ingredients_id_seq; Type: SEQUENCE; Schema: public; Owner: recipebook
--

CREATE SEQUENCE public.ingredients_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: ingredients_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: recipebook
--

ALTER SEQUENCE public.ingredients_id_seq OWNED BY public.ingredients.id;


--
-- Name: locations; Type: TABLE; Schema: public; Owner: recipebook
--

CREATE TABLE public.locations (
    id integer NOT NULL,
    name character varying(64) NOT NULL
);



--
-- Name: locations_id_seq; Type: SEQUENCE; Schema: public; Owner: recipebook
--

CREATE SEQUENCE public.locations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: locations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: recipebook
--

ALTER SEQUENCE public.locations_id_seq OWNED BY public.locations.id;


--
-- Name: meal_names; Type: TABLE; Schema: public; Owner: recipebook
--

CREATE TABLE public.meal_names (
    id integer NOT NULL,
    name character varying(64) NOT NULL
);



--
-- Name: meal_names_id_seq; Type: SEQUENCE; Schema: public; Owner: recipebook
--

CREATE SEQUENCE public.meal_names_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: meal_names_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: recipebook
--

ALTER SEQUENCE public.meal_names_id_seq OWNED BY public.meal_names.id;


--
-- Name: meal_plans; Type: TABLE; Schema: public; Owner: recipebook
--

CREATE TABLE public.meal_plans (
    mealday date NOT NULL,
    meal_name_id integer NOT NULL,
    recipe_id integer NOT NULL,
    servings integer DEFAULT 0 NOT NULL,
    user_id integer,
    id integer NOT NULL
);



--
-- Name: meal_plans_id_seq; Type: SEQUENCE; Schema: public; Owner: recipebook
--

CREATE SEQUENCE public.meal_plans_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: meal_plans_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: recipebook
--

ALTER SEQUENCE public.meal_plans_id_seq OWNED BY public.meal_plans.id;


--
-- Name: preparation_methods; Type: TABLE; Schema: public; Owner: recipebook
--

CREATE TABLE public.preparation_methods (
    id integer NOT NULL,
    name character varying(64) DEFAULT NULL::character varying
);



--
-- Name: preparation_methods_id_seq; Type: SEQUENCE; Schema: public; Owner: recipebook
--

CREATE SEQUENCE public.preparation_methods_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: preparation_methods_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: recipebook
--

ALTER SEQUENCE public.preparation_methods_id_seq OWNED BY public.preparation_methods.id;


--
-- Name: preparation_times; Type: TABLE; Schema: public; Owner: recipebook
--

CREATE TABLE public.preparation_times (
    id integer NOT NULL,
    name character varying(64) NOT NULL
);



--
-- Name: preparation_times_id_seq; Type: SEQUENCE; Schema: public; Owner: recipebook
--

CREATE SEQUENCE public.preparation_times_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: preparation_times_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: recipebook
--

ALTER SEQUENCE public.preparation_times_id_seq OWNED BY public.preparation_times.id;


--
-- Name: price_ranges; Type: TABLE; Schema: public; Owner: recipebook
--

CREATE TABLE public.price_ranges (
    id integer NOT NULL,
    name character varying(16) DEFAULT NULL::character varying
);



--
-- Name: price_ranges_id_seq; Type: SEQUENCE; Schema: public; Owner: recipebook
--

CREATE SEQUENCE public.price_ranges_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: price_ranges_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: recipebook
--

ALTER SEQUENCE public.price_ranges_id_seq OWNED BY public.price_ranges.id;


--
-- Name: recipes; Type: TABLE; Schema: public; Owner: recipebook
--

CREATE TABLE public.recipes (
    id integer NOT NULL,
    name character varying(128) NOT NULL,
    ethnicity_id integer,
    base_type_id integer,
    course_id integer,
    preparation_time_id integer,
    difficulty_id integer,
    serving_size integer,
    directions text,
    comments text,
    source_description character varying(200) DEFAULT NULL::character varying,
    recipe_cost double precision,
    modified date,
    picture bytea,
    picture_type character varying(32) DEFAULT NULL::character varying,
    private boolean NOT NULL,
    system character varying(16) DEFAULT 'usa'::character varying NOT NULL,
    source_id integer,
    user_id integer,
    preparation_method_id integer
);



--
-- Name: recipes_id_seq; Type: SEQUENCE; Schema: public; Owner: recipebook
--

CREATE SEQUENCE public.recipes_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: recipes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: recipebook
--

ALTER SEQUENCE public.recipes_id_seq OWNED BY public.recipes.id;


--
-- Name: related_recipes; Type: TABLE; Schema: public; Owner: recipebook
--

CREATE TABLE public.related_recipes (
    parent_id integer NOT NULL,
    recipe_id integer NOT NULL,
    required boolean,
    sort_order integer,
    id integer NOT NULL
);



--
-- Name: related_recipes_id_seq; Type: SEQUENCE; Schema: public; Owner: recipebook
--

CREATE SEQUENCE public.related_recipes_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: related_recipes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: recipebook
--

ALTER SEQUENCE public.related_recipes_id_seq OWNED BY public.related_recipes.id;


--
-- Name: restaurants; Type: TABLE; Schema: public; Owner: recipebook
--

CREATE TABLE public.restaurants (
    id integer NOT NULL,
    name character varying(64) NOT NULL,
    street character varying(128) DEFAULT NULL::character varying,
    city character varying(64) DEFAULT NULL::character varying,
    state character varying(2) DEFAULT NULL::character varying,
    zip character varying(16) DEFAULT NULL::character varying,
    phone character varying(128) DEFAULT NULL::character varying,
    hours text,
    picture bytea,
    picture_type character varying(64) DEFAULT NULL::character varying,
    menu_text text,
    comments text,
    price_range_id integer,
    delivery boolean,
    carry_out boolean,
    dine_in boolean,
    credit boolean,
    user_id integer,
    website character varying(254) DEFAULT NULL::character varying,
    country character varying(64) DEFAULT NULL::character varying
);



--
-- Name: restaurants_id_seq; Type: SEQUENCE; Schema: public; Owner: recipebook
--

CREATE SEQUENCE public.restaurants_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: restaurants_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: recipebook
--

ALTER SEQUENCE public.restaurants_id_seq OWNED BY public.restaurants.id;


--
-- Name: reviews; Type: TABLE; Schema: public; Owner: recipebook
--

CREATE TABLE public.reviews (
    recipe_id integer NOT NULL,
    comments character varying(255) NOT NULL,
    created timestamp without time zone,
    user_id integer,
    id integer NOT NULL,
    rating integer
);



--
-- Name: reviews_id_seq; Type: SEQUENCE; Schema: public; Owner: recipebook
--

CREATE SEQUENCE public.reviews_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: reviews_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: recipebook
--

ALTER SEQUENCE public.reviews_id_seq OWNED BY public.reviews.id;


--
-- Name: shopping_list_ingredients; Type: TABLE; Schema: public; Owner: recipebook
--

CREATE TABLE public.shopping_list_ingredients (
    id integer NOT NULL,
    shopping_list_id integer NOT NULL,
    ingredient_id integer NOT NULL,
    unit_id integer NOT NULL,
    qualifier character varying(32) DEFAULT NULL::character varying,
    quantity double precision NOT NULL,
    user_id integer
);



--
-- Name: shopping_list_ingredients_id_seq; Type: SEQUENCE; Schema: public; Owner: recipebook
--

CREATE SEQUENCE public.shopping_list_ingredients_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: shopping_list_ingredients_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: recipebook
--

ALTER SEQUENCE public.shopping_list_ingredients_id_seq OWNED BY public.shopping_list_ingredients.id;


--
-- Name: shopping_list_recipes; Type: TABLE; Schema: public; Owner: recipebook
--

CREATE TABLE public.shopping_list_recipes (
    id integer NOT NULL,
    shopping_list_id integer NOT NULL,
    recipe_id integer NOT NULL,
    servings integer DEFAULT 1,
    user_id integer
);



--
-- Name: shopping_list_recipes_id_seq; Type: SEQUENCE; Schema: public; Owner: recipebook
--

CREATE SEQUENCE public.shopping_list_recipes_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: shopping_list_recipes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: recipebook
--

ALTER SEQUENCE public.shopping_list_recipes_id_seq OWNED BY public.shopping_list_recipes.id;


--
-- Name: shopping_lists; Type: TABLE; Schema: public; Owner: recipebook
--

CREATE TABLE public.shopping_lists (
    id integer NOT NULL,
    name character varying(64) NOT NULL,
    user_id integer
);



--
-- Name: shopping_lists_id_seq; Type: SEQUENCE; Schema: public; Owner: recipebook
--

CREATE SEQUENCE public.shopping_lists_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: shopping_lists_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: recipebook
--

ALTER SEQUENCE public.shopping_lists_id_seq OWNED BY public.shopping_lists.id;


--
-- Name: sources; Type: TABLE; Schema: public; Owner: recipebook
--

CREATE TABLE public.sources (
    id integer NOT NULL,
    name character varying(64) DEFAULT NULL::character varying,
    description text,
    user_id integer
);



--
-- Name: sources_id_seq; Type: SEQUENCE; Schema: public; Owner: recipebook
--

CREATE SEQUENCE public.sources_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: sources_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: recipebook
--

ALTER SEQUENCE public.sources_id_seq OWNED BY public.sources.id;


--
-- Name: stores; Type: TABLE; Schema: public; Owner: recipebook
--

CREATE TABLE public.stores (
    name character varying(32) NOT NULL,
    layout text,
    id integer NOT NULL
);



--
-- Name: stores_id_seq; Type: SEQUENCE; Schema: public; Owner: recipebook
--

CREATE SEQUENCE public.stores_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: stores_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: recipebook
--

ALTER SEQUENCE public.stores_id_seq OWNED BY public.stores.id;


--
-- Name: units; Type: TABLE; Schema: public; Owner: recipebook
--

CREATE TABLE public.units (
    id integer NOT NULL,
    name character varying(64) NOT NULL,
    abbreviation character varying(8) NOT NULL,
    system integer NOT NULL,
    sort_order integer NOT NULL
);



--
-- Name: units_id_seq; Type: SEQUENCE; Schema: public; Owner: recipebook
--

CREATE SEQUENCE public.units_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: units_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: recipebook
--

ALTER SEQUENCE public.units_id_seq OWNED BY public.units.id;


--
-- Name: users; Type: TABLE; Schema: public; Owner: recipebook
--

CREATE TABLE public.users (
    username character varying(32) NOT NULL,
    password character varying(255) NOT NULL,
    name character varying(64) NOT NULL,
    access_level integer DEFAULT 0 NOT NULL,
    language character varying(8) DEFAULT 'en'::character varying NOT NULL,
    country character varying(8) DEFAULT 'us'::character varying NOT NULL,
    created timestamp without time zone,
    last_login timestamp without time zone,
    email character varying(64) NOT NULL,
    id integer NOT NULL,
    modified timestamp without time zone,
    reset_token character varying(255) DEFAULT NULL::character varying,
    locked boolean DEFAULT false NOT NULL,
    reset_time timestamp without time zone,
    meal_plan_start_day integer DEFAULT 0 NOT NULL
);



--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: recipebook
--

CREATE SEQUENCE public.users_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: recipebook
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- Name: vendor_products; Type: TABLE; Schema: public; Owner: recipebook
--

CREATE TABLE public.vendor_products (
    id integer NOT NULL,
    ingredient_id integer NOT NULL,
    vendor_id integer NOT NULL,
    code character varying(32) DEFAULT NULL::character varying,
    user_id integer,
    name character varying(255) DEFAULT NULL::character varying
);



--
-- Name: vendor_products_id_seq; Type: SEQUENCE; Schema: public; Owner: recipebook
--

CREATE SEQUENCE public.vendor_products_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: vendor_products_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: recipebook
--

ALTER SEQUENCE public.vendor_products_id_seq OWNED BY public.vendor_products.id;


--
-- Name: vendors; Type: TABLE; Schema: public; Owner: recipebook
--

CREATE TABLE public.vendors (
    id integer NOT NULL,
    name character varying(64) NOT NULL,
    home_url character varying(255) DEFAULT NULL::character varying,
    add_url character varying(255) DEFAULT NULL::character varying,
    request_type character varying(10) DEFAULT 'GET'::character varying,
    format character varying(255) DEFAULT NULL::character varying
);



--
-- Name: vendors_id_seq; Type: SEQUENCE; Schema: public; Owner: recipebook
--

CREATE SEQUENCE public.vendors_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: vendors_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: recipebook
--

ALTER SEQUENCE public.vendors_id_seq OWNED BY public.vendors.id;


--
-- Name: attachments id; Type: DEFAULT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.attachments ALTER COLUMN id SET DEFAULT nextval('public.attachments_id_seq'::regclass);


--
-- Name: base_types id; Type: DEFAULT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.base_types ALTER COLUMN id SET DEFAULT nextval('public.base_types_id_seq'::regclass);


--
-- Name: courses id; Type: DEFAULT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.courses ALTER COLUMN id SET DEFAULT nextval('public.courses_id_seq'::regclass);


--
-- Name: difficulties id; Type: DEFAULT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.difficulties ALTER COLUMN id SET DEFAULT nextval('public.difficulties_id_seq'::regclass);


--
-- Name: ethnicities id; Type: DEFAULT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.ethnicities ALTER COLUMN id SET DEFAULT nextval('public.ethnicities_id_seq'::regclass);


--
-- Name: ingredient_mappings id; Type: DEFAULT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.ingredient_mappings ALTER COLUMN id SET DEFAULT nextval('public.ingredient_mappings_id_seq'::regclass);


--
-- Name: ingredients id; Type: DEFAULT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.ingredients ALTER COLUMN id SET DEFAULT nextval('public.ingredients_id_seq'::regclass);


--
-- Name: locations id; Type: DEFAULT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.locations ALTER COLUMN id SET DEFAULT nextval('public.locations_id_seq'::regclass);


--
-- Name: meal_names id; Type: DEFAULT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.meal_names ALTER COLUMN id SET DEFAULT nextval('public.meal_names_id_seq'::regclass);


--
-- Name: meal_plans id; Type: DEFAULT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.meal_plans ALTER COLUMN id SET DEFAULT nextval('public.meal_plans_id_seq'::regclass);


--
-- Name: preparation_methods id; Type: DEFAULT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.preparation_methods ALTER COLUMN id SET DEFAULT nextval('public.preparation_methods_id_seq'::regclass);


--
-- Name: preparation_times id; Type: DEFAULT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.preparation_times ALTER COLUMN id SET DEFAULT nextval('public.preparation_times_id_seq'::regclass);


--
-- Name: price_ranges id; Type: DEFAULT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.price_ranges ALTER COLUMN id SET DEFAULT nextval('public.price_ranges_id_seq'::regclass);


--
-- Name: recipes id; Type: DEFAULT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.recipes ALTER COLUMN id SET DEFAULT nextval('public.recipes_id_seq'::regclass);


--
-- Name: related_recipes id; Type: DEFAULT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.related_recipes ALTER COLUMN id SET DEFAULT nextval('public.related_recipes_id_seq'::regclass);


--
-- Name: restaurants id; Type: DEFAULT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.restaurants ALTER COLUMN id SET DEFAULT nextval('public.restaurants_id_seq'::regclass);


--
-- Name: reviews id; Type: DEFAULT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.reviews ALTER COLUMN id SET DEFAULT nextval('public.reviews_id_seq'::regclass);


--
-- Name: shopping_list_ingredients id; Type: DEFAULT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.shopping_list_ingredients ALTER COLUMN id SET DEFAULT nextval('public.shopping_list_ingredients_id_seq'::regclass);


--
-- Name: shopping_list_recipes id; Type: DEFAULT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.shopping_list_recipes ALTER COLUMN id SET DEFAULT nextval('public.shopping_list_recipes_id_seq'::regclass);


--
-- Name: shopping_lists id; Type: DEFAULT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.shopping_lists ALTER COLUMN id SET DEFAULT nextval('public.shopping_lists_id_seq'::regclass);


--
-- Name: sources id; Type: DEFAULT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.sources ALTER COLUMN id SET DEFAULT nextval('public.sources_id_seq'::regclass);


--
-- Name: stores id; Type: DEFAULT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.stores ALTER COLUMN id SET DEFAULT nextval('public.stores_id_seq'::regclass);


--
-- Name: units id; Type: DEFAULT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.units ALTER COLUMN id SET DEFAULT nextval('public.units_id_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Name: vendor_products id; Type: DEFAULT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.vendor_products ALTER COLUMN id SET DEFAULT nextval('public.vendor_products_id_seq'::regclass);


--
-- Name: vendors id; Type: DEFAULT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.vendors ALTER COLUMN id SET DEFAULT nextval('public.vendors_id_seq'::regclass);


--
-- Name: attachments attachments_pkey; Type: CONSTRAINT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.attachments
    ADD CONSTRAINT attachments_pkey PRIMARY KEY (id);


--
-- Name: base_types base_types_pkey; Type: CONSTRAINT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.base_types
    ADD CONSTRAINT base_types_pkey PRIMARY KEY (id);


--
-- Name: courses courses_pkey; Type: CONSTRAINT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.courses
    ADD CONSTRAINT courses_pkey PRIMARY KEY (id);


--
-- Name: difficulties difficulties_pkey; Type: CONSTRAINT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.difficulties
    ADD CONSTRAINT difficulties_pkey PRIMARY KEY (id);


--
-- Name: ethnicities ethnicities_pkey; Type: CONSTRAINT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.ethnicities
    ADD CONSTRAINT ethnicities_pkey PRIMARY KEY (id);


--
-- Name: ingredient_mappings ingredient_mappings_pkey; Type: CONSTRAINT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.ingredient_mappings
    ADD CONSTRAINT ingredient_mappings_pkey PRIMARY KEY (id);


--
-- Name: ingredients ingredients_pkey; Type: CONSTRAINT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.ingredients
    ADD CONSTRAINT ingredients_pkey PRIMARY KEY (id);


--
-- Name: locations locations_pkey; Type: CONSTRAINT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.locations
    ADD CONSTRAINT locations_pkey PRIMARY KEY (id);


--
-- Name: meal_names meal_names_pkey; Type: CONSTRAINT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.meal_names
    ADD CONSTRAINT meal_names_pkey PRIMARY KEY (id);


--
-- Name: meal_plans meal_plans_pkey; Type: CONSTRAINT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.meal_plans
    ADD CONSTRAINT meal_plans_pkey PRIMARY KEY (id);


--
-- Name: preparation_methods preparation_methods_pkey; Type: CONSTRAINT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.preparation_methods
    ADD CONSTRAINT preparation_methods_pkey PRIMARY KEY (id);


--
-- Name: preparation_times preparation_times_pkey; Type: CONSTRAINT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.preparation_times
    ADD CONSTRAINT preparation_times_pkey PRIMARY KEY (id);


--
-- Name: price_ranges price_ranges_pkey; Type: CONSTRAINT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.price_ranges
    ADD CONSTRAINT price_ranges_pkey PRIMARY KEY (id);


--
-- Name: recipes recipes_pkey; Type: CONSTRAINT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.recipes
    ADD CONSTRAINT recipes_pkey PRIMARY KEY (id);


--
-- Name: related_recipes related_recipes_pkey; Type: CONSTRAINT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.related_recipes
    ADD CONSTRAINT related_recipes_pkey PRIMARY KEY (id);


--
-- Name: restaurants restaurants_pkey; Type: CONSTRAINT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.restaurants
    ADD CONSTRAINT restaurants_pkey PRIMARY KEY (id);


--
-- Name: reviews reviews_pkey; Type: CONSTRAINT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.reviews
    ADD CONSTRAINT reviews_pkey PRIMARY KEY (id);


--
-- Name: shopping_list_ingredients shopping_list_ingredients_pkey; Type: CONSTRAINT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.shopping_list_ingredients
    ADD CONSTRAINT shopping_list_ingredients_pkey PRIMARY KEY (id);


--
-- Name: shopping_list_recipes shopping_list_recipes_pkey; Type: CONSTRAINT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.shopping_list_recipes
    ADD CONSTRAINT shopping_list_recipes_pkey PRIMARY KEY (id);


--
-- Name: shopping_lists shopping_lists_pkey; Type: CONSTRAINT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.shopping_lists
    ADD CONSTRAINT shopping_lists_pkey PRIMARY KEY (id);


--
-- Name: sources sources_pkey; Type: CONSTRAINT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.sources
    ADD CONSTRAINT sources_pkey PRIMARY KEY (id);


--
-- Name: stores stores_pkey; Type: CONSTRAINT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.stores
    ADD CONSTRAINT stores_pkey PRIMARY KEY (id);


--
-- Name: units units_pkey; Type: CONSTRAINT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.units
    ADD CONSTRAINT units_pkey PRIMARY KEY (id);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: vendor_products vendor_products_pkey; Type: CONSTRAINT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.vendor_products
    ADD CONSTRAINT vendor_products_pkey PRIMARY KEY (id);


--
-- Name: vendors vendors_pkey; Type: CONSTRAINT; Schema: public; Owner: recipebook
--

ALTER TABLE ONLY public.vendors
    ADD CONSTRAINT vendors_pkey PRIMARY KEY (id);


--
-- Name: email; Type: INDEX; Schema: public; Owner: recipebook
--

CREATE UNIQUE INDEX email ON public.users USING btree (email);


--
-- Name: meal_name; Type: INDEX; Schema: public; Owner: recipebook
--

CREATE UNIQUE INDEX meal_name ON public.meal_names USING btree (name);


--
-- Name: mealday; Type: INDEX; Schema: public; Owner: recipebook
--

CREATE UNIQUE INDEX mealday ON public.meal_plans USING btree (mealday, meal_name_id, recipe_id, user_id);


--
-- Name: name; Type: INDEX; Schema: public; Owner: recipebook
--

CREATE UNIQUE INDEX name ON public.base_types USING btree (name);


--
-- Name: recipe_id; Type: INDEX; Schema: public; Owner: recipebook
--

CREATE UNIQUE INDEX recipe_id ON public.reviews USING btree (recipe_id, user_id);


--
-- Name: user_email; Type: INDEX; Schema: public; Owner: recipebook
--

CREATE UNIQUE INDEX user_email ON public.users USING btree (email);


--
-- Name: user_login; Type: INDEX; Schema: public; Owner: recipebook
--

CREATE UNIQUE INDEX user_login ON public.users USING btree (username);


--
-- Name: username; Type: INDEX; Schema: public; Owner: recipebook
--

CREATE UNIQUE INDEX username ON public.users USING btree (username);


--
-- PostgreSQL database dump complete
--

>>>>>>> Stashed changes
