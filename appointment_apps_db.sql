/*
 Navicat Premium Data Transfer

 Source Server         : local
 Source Server Type    : PostgreSQL
 Source Server Version : 160001 (160001)
 Source Host           : localhost:5432
 Source Catalog        : appointment_apps
 Source Schema         : public

 Target Server Type    : PostgreSQL
 Target Server Version : 160001 (160001)
 File Encoding         : 65001

 Date: 16/11/2025 16:05:28
*/


-- ----------------------------
-- Table structure for appointment
-- ----------------------------
DROP TABLE IF EXISTS "public"."appointment";
CREATE TABLE "public"."appointment" (
  "uuid" uuid NOT NULL,
  "title" varchar(255) COLLATE "pg_catalog"."default",
  "start" timestamp(6),
  "end" timestamp(6),
  "created_at" timestamp(6),
  "updated_at" timestamp(6),
  "creator_id" uuid,
  "timezone_location" varchar(255) COLLATE "pg_catalog"."default"
)
;

-- ----------------------------
-- Records of appointment
-- ----------------------------
INSERT INTO "public"."appointment" VALUES ('4110ff48-c6a9-4703-ac80-718fa44a45b5', 'Test appointment Indo', '2025-11-17 02:00:00', '2025-11-17 03:00:00', '2025-11-16 14:43:56', '2025-11-16 14:43:56', 'db73d36d-95b0-473b-a004-00326bedf3b2', 'Asia/Jakarta');
INSERT INTO "public"."appointment" VALUES ('72698e7a-4a26-4ea3-841f-3ae3f433747f', 'Create appointment from indonesia', '2025-11-18 02:00:00', '2025-11-18 04:00:00', '2025-11-16 14:46:39', '2025-11-16 14:46:39', 'db73d36d-95b0-473b-a004-00326bedf3b2', 'Asia/Jakarta');
INSERT INTO "public"."appointment" VALUES ('72894245-67f2-46db-87f9-6a9fc4b42b05', 'Create test appointment - Auckland', '2025-11-19 02:00:00', '2025-11-19 04:00:00', '2025-11-16 14:53:46', '2025-11-16 14:53:46', 'c7440324-72d6-4f91-bed3-e6ffb0544441', 'Pacific/Auckland');

-- ----------------------------
-- Table structure for detail_appointment
-- ----------------------------
DROP TABLE IF EXISTS "public"."detail_appointment";
CREATE TABLE "public"."detail_appointment" (
  "uuid" uuid NOT NULL,
  "appointment_id" uuid,
  "invite_to" uuid
)
;

-- ----------------------------
-- Records of detail_appointment
-- ----------------------------
INSERT INTO "public"."detail_appointment" VALUES ('46af5120-a28f-4bd1-b0f0-0b7f9cf854b8', '4110ff48-c6a9-4703-ac80-718fa44a45b5', 'c7440324-72d6-4f91-bed3-e6ffb0544441');
INSERT INTO "public"."detail_appointment" VALUES ('5ce01429-5c12-4eaf-a9b7-a614ac916b8a', '4110ff48-c6a9-4703-ac80-718fa44a45b5', 'ae8a8ab7-86da-4be7-b6bb-dbbeb7af96ed');
INSERT INTO "public"."detail_appointment" VALUES ('3f769630-60a7-47cf-bb94-b8d3d51e1d32', '72698e7a-4a26-4ea3-841f-3ae3f433747f', 'c7440324-72d6-4f91-bed3-e6ffb0544441');
INSERT INTO "public"."detail_appointment" VALUES ('0ad60b84-647c-4f40-bb2f-ab9f27a695ef', '72698e7a-4a26-4ea3-841f-3ae3f433747f', '9a242e22-13e8-4200-a1e2-f27df3185b5f');
INSERT INTO "public"."detail_appointment" VALUES ('e075d4f7-c0f5-4aed-9645-c3b10d3c2d4b', '72698e7a-4a26-4ea3-841f-3ae3f433747f', '173a4c92-c5fc-4915-99b2-8ed66879a24a');
INSERT INTO "public"."detail_appointment" VALUES ('c845826c-82c2-443a-8c1e-415d91458048', '72894245-67f2-46db-87f9-6a9fc4b42b05', '9d09dc69-a125-425c-a9aa-634050f45499');
INSERT INTO "public"."detail_appointment" VALUES ('beba92aa-2482-4c3d-9340-84ced01531f4', '72894245-67f2-46db-87f9-6a9fc4b42b05', 'db73d36d-95b0-473b-a004-00326bedf3b2');
INSERT INTO "public"."detail_appointment" VALUES ('29396aa9-c7ef-4c6f-b7bb-10f977cc411c', '72894245-67f2-46db-87f9-6a9fc4b42b05', 'a4558ba6-6d43-47df-8f6b-5cef7924292e');
INSERT INTO "public"."detail_appointment" VALUES ('b83fe386-6f47-42da-999f-0d9a65ff2f89', '72894245-67f2-46db-87f9-6a9fc4b42b05', '9a242e22-13e8-4200-a1e2-f27df3185b5f');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS "public"."users";
CREATE TABLE "public"."users" (
  "uuid" uuid NOT NULL,
  "username" varchar(30) COLLATE "pg_catalog"."default",
  "name" varchar(255) COLLATE "pg_catalog"."default",
  "preffered_timezone" varchar(255) COLLATE "pg_catalog"."default",
  "created_at" timestamp(6),
  "updated_at" timestamp(6)
)
;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO "public"."users" VALUES ('fe8b5ac0-319d-4e15-8730-acb53f2ca6bf', 'abduljehann', 'Abdul Jehan', 'Asia/Jakarta', '2025-11-14 21:51:16', '2025-11-14 21:51:16');
INSERT INTO "public"."users" VALUES ('173a4c92-c5fc-4915-99b2-8ed66879a24a', 'ajiparamab77', 'Aji Parama', 'Asia/Jakarta', NULL, '2025-11-14 23:40:17');
INSERT INTO "public"."users" VALUES ('a4558ba6-6d43-47df-8f6b-5cef7924292e', 'greedsaf', 'Fahri', 'Asia/Jakarta', '2025-11-15 11:07:46', '2025-11-15 11:07:50');
INSERT INTO "public"."users" VALUES ('9d09dc69-a125-425c-a9aa-634050f45499', 'ridwanhz', 'Ridwan Hamzah', 'Asia/Jakarta', '2025-11-15 11:09:35', '2025-11-15 11:09:38');
INSERT INTO "public"."users" VALUES ('9e81b3f5-0de8-49a6-83e0-6d2192e901f8', 'setyoanggoro', 'Setyo Anggoro', 'Asia/Jakarta', '2025-11-15 11:10:08', '2025-11-15 11:10:11');
INSERT INTO "public"."users" VALUES ('c7440324-72d6-4f91-bed3-e6ffb0544441', 'michael08', 'Michael Sutanto', 'Pacific/Auckland', '2025-11-16 00:23:16', '2025-11-16 00:23:16');
INSERT INTO "public"."users" VALUES ('5b19298f-173a-4cea-9937-0e9ca330207d', 'josephadrian', 'Josep Adrian', 'Pacific/Auckland', '2025-11-16 00:23:38', '2025-11-16 00:23:38');
INSERT INTO "public"."users" VALUES ('9a242e22-13e8-4200-a1e2-f27df3185b5f', 'choumlbb', 'Chou', 'Pacific/Auckland', '2025-11-16 00:24:04', '2025-11-16 00:24:04');
INSERT INTO "public"."users" VALUES ('db73d36d-95b0-473b-a004-00326bedf3b2', 'ajiparama', 'Aji P', 'Asia/Jakarta', '2025-11-16 11:50:05', '2025-11-16 11:50:05');
INSERT INTO "public"."users" VALUES ('ae8a8ab7-86da-4be7-b6bb-dbbeb7af96ed', 'josephjdm', 'Josep Jordan Michael', 'Pacific/Auckland', '2025-11-16 17:50:33', '2025-11-16 12:03:28');

-- ----------------------------
-- Primary Key structure for table appointment
-- ----------------------------
ALTER TABLE "public"."appointment" ADD CONSTRAINT "appointment_pkey" PRIMARY KEY ("uuid");

-- ----------------------------
-- Primary Key structure for table detail_appointment
-- ----------------------------
ALTER TABLE "public"."detail_appointment" ADD CONSTRAINT "detail_appointment_pkey" PRIMARY KEY ("uuid");

-- ----------------------------
-- Primary Key structure for table users
-- ----------------------------
ALTER TABLE "public"."users" ADD CONSTRAINT "users_pkey" PRIMARY KEY ("uuid");

-- ----------------------------
-- Foreign Keys structure for table appointment
-- ----------------------------
ALTER TABLE "public"."appointment" ADD CONSTRAINT "fk1_user_appointment" FOREIGN KEY ("creator_id") REFERENCES "public"."users" ("uuid") ON DELETE CASCADE ON UPDATE RESTRICT;

-- ----------------------------
-- Foreign Keys structure for table detail_appointment
-- ----------------------------
ALTER TABLE "public"."detail_appointment" ADD CONSTRAINT "fk1_appointment" FOREIGN KEY ("appointment_id") REFERENCES "public"."appointment" ("uuid") ON DELETE CASCADE ON UPDATE RESTRICT;
ALTER TABLE "public"."detail_appointment" ADD CONSTRAINT "fk1_users" FOREIGN KEY ("invite_to") REFERENCES "public"."users" ("uuid") ON DELETE CASCADE ON UPDATE RESTRICT;
