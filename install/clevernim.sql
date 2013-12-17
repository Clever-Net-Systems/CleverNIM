/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `AuthAssignment`
--

DROP TABLE IF EXISTS `AuthAssignment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `AuthAssignment` (
  `itemname` varchar(64) NOT NULL,
  `userid` varchar(64) NOT NULL,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`itemname`,`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `AuthAssignment`
--

LOCK TABLES `AuthAssignment` WRITE;
/*!40000 ALTER TABLE `AuthAssignment` DISABLE KEYS */;
INSERT INTO `AuthAssignment` VALUES ('Admin','1',NULL,'N;'),('Admin','12',NULL,'N;'),('Admin','13',NULL,'N;'),('Administrateur','8',NULL,'N;'),('AppAdmin','12',NULL,'N;'),('EZAdmin','12',NULL,'N;'),('EZAdmin','13',NULL,'N;'),('GroupAdmin','2',NULL,'N;'),('GroupAdmin','3',NULL,'N;'),('GroupManager','3',NULL,'N;'),('RA','4',NULL,'N;'),('RA','6',NULL,'N;'),('RA','7',NULL,'N;'),('RA','8',NULL,'N;'),('RA','9',NULL,'N;'),('StandardUser','15',NULL,'N;'),('TagAdmin','3',NULL,'N;');
/*!40000 ALTER TABLE `AuthAssignment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `AuthItem`
--

DROP TABLE IF EXISTS `AuthItem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `AuthItem` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `AuthItem`
--

LOCK TABLES `AuthItem` WRITE;
/*!40000 ALTER TABLE `AuthItem` DISABLE KEYS */;
INSERT INTO `AuthItem` VALUES ('Admin',2,'Application administrator',NULL,'N;'),('AuditTrail.AuditAdmin.AuditAdmin',0,'View audit log records',NULL,'N;'),('Authenticated',2,'Authenticated user [auto - ne pas utiliser]','return !Yii::app()->user->isGuest;','N;'),('AutoTag.Admin',0,'actionAdmin',NULL,'N;'),('AutoTag.AdminGroup',0,'actionAdmin',NULL,'N;'),('AutoTag.Create',0,'actionCreate',NULL,'N;'),('AutoTag.CreateGroup',0,'actionCreate',NULL,'N;'),('AutoTag.Delete',0,'actionDelete',NULL,'N;'),('AutoTag.DeleteGroup',0,'actionDelete',NULL,'N;'),('AutoTag.Export',0,'actionExport',NULL,'N;'),('AutoTag.Update',0,'actionUpdate',NULL,'N;'),('AutoTag.UpdateGroup',0,'actionUpdate',NULL,'N;'),('AutoTag_EditAll',1,'Edit any automatic tag',NULL,'N;'),('AutoTag_EditGroup',1,'Edit any automatic tag of an authorized node',NULL,'N;'),('AutoTag_ExportCSV',1,'Export all tags',NULL,'N;'),('AutoTag_ViewAll',1,'View all automatic tags',NULL,'N;'),('AutoTag_ViewGroup',1,'View all authorized automatic tags',NULL,'N;'),('Base_Navigation',1,'Base_Navigation',NULL,'N;'),('DataAnalysis',1,'Access the data analysis tool',NULL,'N;'),('DataAnalyzer',2,'User of the data analysis tool',NULL,'N;'),('DatawarehouseGeneration',1,'Reconstruct the datawarehouse',NULL,'N;'),('Group.Admin',0,'actionAdmin',NULL,'N;'),('Group.Create',0,'actionCreate',NULL,'N;'),('Group.Delete',0,'actionDelete',NULL,'N;'),('Group.Export',0,'actionExport',NULL,'N;'),('Group.Update',0,'actionUpdate',NULL,'N;'),('GroupAdmin',2,'Node administrator restricted to authorized nodes',NULL,'N;'),('GroupManager',2,'Can manage groups',NULL,'N;'),('Group_Edit',1,'Edit restriction groups',NULL,'N;'),('Group_ExportCSV',1,'Export restriction groups',NULL,'N;'),('Group_View',1,'View restriction groups',NULL,'N;'),('Guest',2,'Read-only guest restricted to authorized nodes',NULL,'N;'),('Internal_Admin',1,'Edit internal settings and security',NULL,'N;'),('Internal_View',1,'View internal settings and security',NULL,'N;'),('Inventory.Admin',0,'actionAdmin',NULL,'N;'),('Inventory.AdminGroup',0,'actionAdmin',NULL,'N;'),('Inventory.Export',0,'actionExport',NULL,'N;'),('Inventory.Generate',0,'actionGenerate',NULL,'N;'),('Inventory_ExportCSV',1,'Export complete inventory',NULL,'N;'),('Inventory_Generate',1,'Generate inventory',NULL,'N;'),('Inventory_ViewAll',1,'View complete inventory',NULL,'N;'),('Inventory_ViewGroup',1,'View inventory of authorized nodes',NULL,'N;'),('Logs_ExportCSV',1,'Export logs',NULL,'N;'),('Logs_View',1,'View logs',NULL,'N;'),('ManifestSynchronization',1,'Synchronize manifests',NULL,'N;'),('MediaManager',1,'Access the Media Manager',NULL,'N;'),('Node.Admin',0,'actionAdmin',NULL,'N;'),('Node.AdminGroup',0,'actionAdmin',NULL,'N;'),('Node.Create',0,'actionCreate',NULL,'N;'),('Node.Delete',0,'actionDelete',NULL,'N;'),('Node.DeleteGroup',0,'actionDelete',NULL,'N;'),('Node.Export',0,'actionExport',NULL,'N;'),('Node.Kick',0,'actionKick',NULL,'N;'),('Node.KickGroup',0,'actionKick',NULL,'N;'),('Node.Update',0,'actionUpdate',NULL,'N;'),('Node.UpdateGroup',0,'actionUpdate',NULL,'N;'),('Node.Vnc',0,'actionVnc',NULL,'N;'),('Node.VncGroup',0,'actionVnc',NULL,'N;'),('Node_Add',1,'Add a node',NULL,'N;'),('Node_EditAll',1,'Edit any node',NULL,'N;'),('Node_EditGroup',1,'Edit any authorized node',NULL,'N;'),('Node_ExportCSV',1,'Export all nodes',NULL,'N;'),('Node_SetEnvironmentAll',1,'Set environment of any node',NULL,'N;'),('Node_SetEnvironmentGroup',1,'Set environment of any authorized node',NULL,'N;'),('Node_ViewAll',1,'View All nodes',NULL,'N;'),('Node_ViewGroup',1,'View authorized nodes',NULL,'N;'),('Node_VNCAll',1,'Take remote control of any node',NULL,'N;'),('Node_VNCGroup',1,'Take remote control of any authorized node',NULL,'N;'),('PuppetDBStats',1,'View PuppetDB statistics',NULL,'N;'),('Rights_Assignments',1,'Assign rights to users',NULL,'N;'),('Rights_Operations',1,'Manage low-level authorization operations',NULL,'N;'),('Rights_Permissions',1,'Assign permissions to roles',NULL,'N;'),('Rights_Roles',1,'Manage roles',NULL,'N;'),('Rights_Tasks',1,'Manage tasks',NULL,'N;'),('SearchAll',1,'Perform search on all nodes',NULL,'N;'),('SearchGroup',1,'Perform search on authorized nodes',NULL,'N;'),('SearchOptions',1,'Modify search options',NULL,'N;'),('Site.Error',0,'View error pages',NULL,'N;'),('Site.Home',0,'View site homepage',NULL,'N;'),('Site.Index',0,'View site entry page',NULL,'N;'),('Site.Login',0,'Site login page',NULL,'N;'),('Site.Logout',0,'Site logout action',NULL,'N;'),('Site.Search',0,'actionSearch',NULL,'N;'),('Site.SearchGroup',0,'actionSearch',NULL,'N;'),('StandardUser',2,'Standard application user',NULL,'N;'),('Tag.Admin',0,'Access to Tag admin interface',NULL,'N;'),('Tag.Create',0,'Create Tag records',NULL,'N;'),('Tag.Delete',0,'Delete Tag records',NULL,'N;'),('Tag.DeleteGroup',0,'actionDelete',NULL,'N;'),('Tag.Export',0,'actionExport',NULL,'N;'),('Tag.Update',0,'Update Tag records',NULL,'N;'),('Tag.UpdateGroup',0,'actionUpdate',NULL,'N;'),('TagType.Admin',0,'actionAdmin',NULL,'N;'),('TagType.Create',0,'actionCreate',NULL,'N;'),('TagType.Delete',0,'actionDelete',NULL,'N;'),('TagType.Export',0,'actionExport',NULL,'N;'),('TagType.Update',0,'actionUpdate',NULL,'N;'),('TagTypeAdmin',2,'Tag type manager',NULL,'N;'),('TagType_Edit',1,'Edit tag types',NULL,'N;'),('TagType_ExportCSV',1,'Export tag types',NULL,'N;'),('TagType_View',1,'View tag types',NULL,'N;'),('Tag_AddAll',1,'Add a tag',NULL,'N;'),('Tag_AddGroup',1,'Add a tag to any authorized node',NULL,'N;'),('Tag_EditAll',1,'Edit all Tag records',NULL,'N;'),('Tag_EditGroup',1,'Edit any tag of an authorized node',NULL,'N;'),('Tag_ExportCSV',1,'Export all tags',NULL,'N;'),('Tag_ViewAll',1,'View all Tag records',NULL,'N;'),('Tag_ViewGroup',1,'View all authorized tags',NULL,'N;'),('User_Add',1,'Add a user',NULL,'N;'),('User_Delete',1,'Delete any user',NULL,'N;'),('User_Edit',1,'Edit any user',NULL,'N;'),('User_EditAll',1,'User_EditAll',NULL,'N;'),('User_ExportCSV',1,'Export all users',NULL,'N;'),('User_UpdateSelf',1,'User_UpdateSelf',NULL,'N;'),('User_View',1,'User_View',NULL,'N;');
/*!40000 ALTER TABLE `AuthItem` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `AuthItemChild`
--

DROP TABLE IF EXISTS `AuthItemChild`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `AuthItemChild` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `AuthItemChild`
--

LOCK TABLES `AuthItemChild` WRITE;
/*!40000 ALTER TABLE `AuthItemChild` DISABLE KEYS */;
INSERT INTO `AuthItemChild` VALUES ('Audit_View','AuditTrail.AuditAdmin.AuditAdmin'),('AutoTag_ViewAll','AutoTag.Admin'),('AutoTag_ViewGroup','AutoTag.AdminGroup'),('AutoTag_ViewAll','AutoTag.Coda'),('AutoTag_ViewGroup','AutoTag.CodaGroup'),('AutoTag_AddAll','AutoTag.Create'),('AutoTag_EditAll','AutoTag.Create'),('AutoTag_EditGroup','AutoTag.CreateGroup'),('AutoTag_EditAll','AutoTag.Delete'),('AutoTag_EditGroup','AutoTag.DeleteGroup'),('AutoTag_ExportCSV','AutoTag.Export'),('AutoTag_EditAll','AutoTag.Update'),('AutoTag_EditGroup','AutoTag.UpdateGroup'),('Admin','AutoTag_AddAll'),('Admin','AutoTag_AddGroup'),('GroupAdmin','AutoTag_AddGroup'),('Admin','AutoTag_DeleteAll'),('Admin','AutoTag_DeleteGroup'),('GroupAdmin','AutoTag_DeleteGroup'),('Admin','AutoTag_EditAll'),('Admin','AutoTag_EditGroup'),('GroupAdmin','AutoTag_EditGroup'),('Admin','AutoTag_ExportCSV'),('GroupAdmin','AutoTag_ExportCSV'),('Admin','AutoTag_ViewAll'),('Admin','AutoTag_ViewGroup'),('GroupAdmin','AutoTag_ViewGroup'),('Guest','AutoTag_ViewGroup'),('Authenticated','Base_Navigation'),('StandardUser','Base_Navigation'),('Administrateur','CascadeDelete'),('TagAdmin','CascadeDelete'),('Admin','DataAnalysis'),('DataAnalyzer','DataAnalysis'),('Admin','DatawarehouseGeneration'),('Ecole.ViewAll','Ecole.Admin'),('Ecole.ViewSelf','Ecole.Admin'),('Ecole.CodaAll','Ecole.Coda'),('Ecole.CodaSelf','Ecole.Coda'),('Ecole_ViewAll','Ecole.CodaAll'),('Ecole_ViewSelf','Ecole.CodaSelf'),('Ecole_EditAll','Ecole.Create'),('Ecole_EditSelf','Ecole.Create'),('Ecole_EditAll','Ecole.Delete'),('Ecole_EditAll','Ecole.Update'),('Ecole_EditSelf','Ecole.UpdateDeleteSelf'),('Ecole_ViewAll','Ecole.ViewAll'),('EZAdmin','Ecole.ViewAll'),('Ecole_ViewSelf','Ecole.ViewSelf'),('AppAdmin','Ecole_EditSelf'),('StandardUser','Ecole_EditSelf'),('AppAdmin','Ecole_ViewAll'),('StandardUser','Ecole_ViewSelf'),('Fait.ViewAll','Fait.Admin'),('Fait.ViewSelf','Fait.Admin'),('Fait.CodaAll','Fait.Coda'),('Fait.CodaSelf','Fait.Coda'),('Fait_ViewAll','Fait.CodaAll'),('Fait_ViewSelf','Fait.CodaSelf'),('Fait_EditAll','Fait.Create'),('Fait_EditSelf','Fait.Create'),('Fait_EditAll','Fait.Delete'),('Fait_EditAll','Fait.Update'),('Fait_EditSelf','Fait.UpdateDeleteSelf'),('Fait_ViewAll','Fait.ViewAll'),('Fait_ViewSelf','Fait.ViewSelf'),('AppAdmin','Fait_EditSelf'),('StandardUser','Fait_EditSelf'),('Fait_groupement.ViewAll','Fait_groupement.Admin'),('Fait_groupement.ViewSelf','Fait_groupement.Admin'),('Fait_groupement.CodaAll','Fait_groupement.Coda'),('Fait_groupement.CodaSelf','Fait_groupement.Coda'),('Fait_groupement_ViewAll','Fait_groupement.CodaAll'),('Fait_groupement_ViewSelf','Fait_groupement.CodaSelf'),('Fait_groupement_EditAll','Fait_groupement.Create'),('Fait_groupement_EditSelf','Fait_groupement.Create'),('Fait_groupement_EditAll','Fait_groupement.Delete'),('Fait_groupement_EditAll','Fait_groupement.Update'),('Fait_groupement_EditSelf','Fait_groupement.UpdateDeleteSelf'),('Fait_groupement_ViewAll','Fait_groupement.ViewAll'),('Fait_groupement_ViewSelf','Fait_groupement.ViewSelf'),('AppAdmin','Fait_groupement_EditSelf'),('StandardUser','Fait_groupement_EditSelf'),('AppAdmin','Fait_groupement_ViewAll'),('StandardUser','Fait_groupement_ViewSelf'),('Fait_tagauto.ViewAll','Fait_tagauto.Admin'),('Fait_tagauto.ViewSelf','Fait_tagauto.Admin'),('Fait_tagauto.CodaAll','Fait_tagauto.Coda'),('Fait_tagauto.CodaSelf','Fait_tagauto.Coda'),('Fait_tagauto_ViewAll','Fait_tagauto.CodaAll'),('Fait_tagauto_ViewSelf','Fait_tagauto.CodaSelf'),('Fait_tagauto_EditAll','Fait_tagauto.Create'),('Fait_tagauto_EditSelf','Fait_tagauto.Create'),('Fait_tagauto_EditAll','Fait_tagauto.Delete'),('Fait_tagauto_EditAll','Fait_tagauto.Update'),('Fait_tagauto_EditSelf','Fait_tagauto.UpdateDeleteSelf'),('Fait_tagauto_ViewAll','Fait_tagauto.ViewAll'),('Fait_tagauto_ViewSelf','Fait_tagauto.ViewSelf'),('AppAdmin','Fait_tagauto_EditSelf'),('StandardUser','Fait_tagauto_EditSelf'),('AppAdmin','Fait_tagauto_ViewAll'),('StandardUser','Fait_tagauto_ViewSelf'),('AppAdmin','Fait_ViewAll'),('StandardUser','Fait_ViewSelf'),('Group_Edit','Group.Admin'),('Group_View','Group.Admin'),('Group_Edit','Group.Coda'),('Group_View','Group.Coda'),('Group_Add','Group.Create'),('Group_Edit','Group.Create'),('Group_Delete','Group.Delete'),('Group_Edit','Group.Delete'),('Group_ExportCSV','Group.Export'),('Group_Edit','Group.Update'),('Groupement.ViewAll','Groupement.Admin'),('Groupement.ViewSelf','Groupement.Admin'),('Groupement.CodaAll','Groupement.Coda'),('Groupement.CodaSelf','Groupement.Coda'),('Groupement_ViewAll','Groupement.CodaAll'),('Groupement_ViewSelf','Groupement.CodaSelf'),('Groupement_EditAll','Groupement.Create'),('Groupement_EditSelf','Groupement.Create'),('Groupement_EditAll','Groupement.Delete'),('Groupement_EditAll','Groupement.Update'),('Groupement_EditSelf','Groupement.UpdateDeleteSelf'),('Groupement_ViewAll','Groupement.ViewAll'),('Groupement_ViewSelf','Groupement.ViewSelf'),('AppAdmin','Groupement_EditSelf'),('StandardUser','Groupement_EditSelf'),('AppAdmin','Groupement_ViewAll'),('StandardUser','Groupement_ViewSelf'),('Admin','Group_Edit'),('GroupManager','Group_Edit'),('Admin','Group_ExportCSV'),('GroupManager','Group_ExportCSV'),('Admin','Group_View'),('GroupManager','Group_View'),('Inventory_ViewAll','Inventory.Admin'),('Inventory_ViewGroup','Inventory.AdminGroup'),('Inventory_ExportCSV','Inventory.Export'),('Inventory_Generate','Inventory.Generate'),('Admin','InventoryGeneration'),('Admin','Inventory_ExportCSV'),('GroupAdmin','Inventory_ExportCSV'),('Admin','Inventory_ViewAll'),('Admin','Inventory_ViewGroup'),('GroupAdmin','Inventory_ViewGroup'),('Guest','Inventory_ViewGroup'),('Admin','ManifestSynchronization'),('Admin','MediaManager'),('TagTypeAdmin','MediaManager'),('Node_ViewAll','Node.Admin'),('Node_ViewGroup','Node.AdminGroup'),('Node_ViewAll','Node.Coda'),('Node_ViewGroup','Node.CodaGroup'),('Node_Add','Node.Create'),('Node_DeleteAll','Node.Delete'),('Node_EditAll','Node.Delete'),('Node_DeleteGroup','Node.DeleteGroup'),('Node_EditGroup','Node.DeleteGroup'),('Node_ExportCSV','Node.Export'),('Node_SetEnvironment','Node.Kick'),('Node_SetEnvironmentAll','Node.Kick'),('Node_SetEnvironmentGroup','Node.KickGroup'),('Node_EditAll','Node.Update'),('Node_EditGroup','Node.UpdateGroup'),('Node_VNCAll','Node.Vnc'),('Node_VNCGroup','Node.VncGroup'),('Admin','Node_Add'),('GroupAdmin','Node_Add'),('GroupAdmin','Node_DeleteGroup'),('Admin','Node_EditAll'),('Admin','Node_EditGroup'),('GroupAdmin','Node_EditGroup'),('Admin','Node_ExportCSV'),('GroupAdmin','Node_ExportCSV'),('GroupAdmin','Node_SetEnvironment'),('Admin','Node_SetEnvironmentAll'),('Admin','Node_SetEnvironmentGroup'),('GroupAdmin','Node_SetEnvironmentGroup'),('Admin','Node_ViewAll'),('Admin','Node_ViewGroup'),('GroupAdmin','Node_ViewGroup'),('Guest','Node_ViewGroup'),('GroupAdmin','Node_VNC'),('Admin','Node_VNCAll'),('Admin','Node_VNCGroup'),('GroupAdmin','Node_VNCGroup'),('Node_ViewGroup','Poste.Admin'),('Poste.ViewAll','Poste.Admin'),('Poste.ViewSelf','Poste.Admin'),('Node_ViewGroup','Poste.Coda'),('Poste.CodaAll','Poste.Coda'),('Poste.CodaSelf','Poste.Coda'),('Poste_ViewAll','Poste.CodaAll'),('Poste_ViewSelf','Poste.CodaSelf'),('Node_Add','Poste.Create'),('Poste_EditAll','Poste.Create'),('Poste_EditSelf','Poste.Create'),('Node_EditAll','Poste.Delete'),('Poste_EditAll','Poste.Delete'),('Node_ExportCSV','Poste.Export'),('Node_EditAll','Poste.Update'),('Poste_EditAll','Poste.Update'),('Poste_EditSelf','Poste.UpdateDeleteSelf'),('Poste_EditAll','Poste.updateEditable'),('Poste_ViewAll','Poste.ViewAll'),('Poste_ViewSelf','Poste.ViewSelf'),('Node_VNCAll','Poste.Vnc'),('Node_VNCGroup','Poste.Vnc'),('RA','Poste_EditAll'),('AppAdmin','Poste_EditSelf'),('RA','Poste_EditSelf'),('StandardUser','Poste_EditSelf'),('AppAdmin','Poste_ViewAll'),('RA','Poste_ViewAll'),('RA','Poste_ViewSelf'),('StandardUser','Poste_ViewSelf'),('Profil.ViewAll','Profil.Admin'),('Profil.ViewSelf','Profil.Admin'),('Profil.CodaAll','Profil.Coda'),('Profil.CodaSelf','Profil.Coda'),('Profil_ViewAll','Profil.CodaAll'),('Profil_ViewSelf','Profil.CodaSelf'),('Profil_EditAll','Profil.Create'),('Profil_EditSelf','Profil.Create'),('Profil_EditAll','Profil.Delete'),('Profil_EditAll','Profil.Update'),('Profil_EditSelf','Profil.UpdateDeleteSelf'),('Profil_ViewAll','Profil.ViewAll'),('Profil_ViewSelf','Profil.ViewSelf'),('AppAdmin','Profil_EditSelf'),('StandardUser','Profil_EditSelf'),('AppAdmin','Profil_ViewAll'),('StandardUser','Profil_ViewSelf'),('GroupAdmin','SearchGroup'),('Guest','SearchGroup'),('Selection.ViewAll','Selection.Admin'),('Selection.ViewSelf','Selection.Admin'),('Selection.CodaAll','Selection.Coda'),('Selection.CodaSelf','Selection.Coda'),('Selection_ViewAll','Selection.CodaAll'),('Selection_ViewSelf','Selection.CodaSelf'),('Selection_EditAll','Selection.Create'),('Selection_EditSelf','Selection.Create'),('Selection_EditAll','Selection.Delete'),('Selection_EditAll','Selection.Update'),('Selection_EditSelf','Selection.UpdateDeleteSelf'),('Selection_ViewAll','Selection.ViewAll'),('Selection_ViewSelf','Selection.ViewSelf'),('AppAdmin','Selection_EditSelf'),('StandardUser','Selection_EditSelf'),('AppAdmin','Selection_ViewAll'),('StandardUser','Selection_ViewSelf'),('Authenticated','Site.*'),('Base_Navigation','Site.Error'),('Base_Navigation','Site.Home'),('Base_Navigation','Site.Index'),('Base_Navigation','Site.Login'),('Base_Navigation','Site.Logout'),('SearchGroup','Site.SearchGroup'),('Tag.ViewAll','Tag.Admin'),('Tag.ViewSelf','Tag.Admin'),('Tag_ViewGroup','Tag.Admin'),('Tag.CodaAll','Tag.Coda'),('Tag.CodaSelf','Tag.Coda'),('Tag_ViewAll','Tag.CodaAll'),('Tag_ViewSelf','Tag.CodaSelf'),('Tag_AddAll','Tag.Create'),('Tag_AddGroup','Tag.Create'),('Tag_EditAll','Tag.Create'),('Tag_EditSelf','Tag.Create'),('Tag_AddGroup','Tag.CreateGroup'),('Tag_EditGroup','Tag.CreateGroup'),('Tag_EditAll','Tag.Delete'),('Tag_EditGroup','Tag.DeleteGroup'),('Tag_EditAll','Tag.Update'),('Tag_EditSelf','Tag.UpdateDeleteSelf'),('Tag_EditGroup','Tag.UpdateGroup'),('Tag_ViewAll','Tag.ViewAll'),('Tag_ViewSelf','Tag.ViewSelf'),('AutoTag_ViewGroup','Tagauto.Admin'),('Tagauto.ViewAll','Tagauto.Admin'),('Tagauto.ViewSelf','Tagauto.Admin'),('Tagauto.CodaAll','Tagauto.Coda'),('Tagauto.CodaSelf','Tagauto.Coda'),('Tagauto_ViewAll','Tagauto.CodaAll'),('Tagauto_ViewSelf','Tagauto.CodaSelf'),('Tagauto_EditAll','Tagauto.Create'),('Tagauto_EditSelf','Tagauto.Create'),('Tagauto_EditAll','Tagauto.Delete'),('Tagauto_EditAll','Tagauto.Update'),('Tagauto_EditSelf','Tagauto.UpdateDeleteSelf'),('Tagauto_ViewAll','Tagauto.ViewAll'),('Tagauto_ViewSelf','Tagauto.ViewSelf'),('AppAdmin','Tagauto_EditSelf'),('StandardUser','Tagauto_EditSelf'),('AppAdmin','Tagauto_ViewAll'),('StandardUser','Tagauto_ViewSelf'),('Tagparam.ViewAll','Tagparam.Admin'),('Tagparam.ViewSelf','Tagparam.Admin'),('Tagparam.CodaAll','Tagparam.Coda'),('Tagparam.CodaSelf','Tagparam.Coda'),('Tagparam_ViewAll','Tagparam.CodaAll'),('Tagparam_ViewSelf','Tagparam.CodaSelf'),('Tagparam_EditAll','Tagparam.Create'),('Tagparam_EditSelf','Tagparam.Create'),('Tagparam_EditAll','Tagparam.Delete'),('Tagparam_EditAll','Tagparam.Update'),('Tagparam_EditSelf','Tagparam.UpdateDeleteSelf'),('Tagparam_ViewAll','Tagparam.ViewAll'),('Tagparam_ViewSelf','Tagparam.ViewSelf'),('TagAdmin','Tagparam_EditAll'),('AppAdmin','Tagparam_EditSelf'),('StandardUser','Tagparam_EditSelf'),('TagAdmin','Tagparam_EditSelf'),('AppAdmin','Tagparam_ViewAll'),('TagAdmin','Tagparam_ViewAll'),('StandardUser','Tagparam_ViewSelf'),('TagAdmin','Tagparam_ViewSelf'),('TagType_Edit','TagType.Admin'),('TagType_View','TagType.Admin'),('TagType_Edit','TagType.Coda'),('TagType_View','TagType.Coda'),('TagType_Edit','TagType.Create'),('TagType_Edit','TagType.Delete'),('TagType_ExportCSV','TagType.Export'),('TagType_Edit','TagType.Update'),('TagTypeAdmin','TagType_Add'),('TagTypeAdmin','TagType_Delete'),('TagTypeAdmin','TagType_Edit'),('TagTypeAdmin','TagType_ExportCSV'),('TagTypeAdmin','TagType_View'),('GroupAdmin','Tag_AddGroup'),('GroupAdmin','Tag_DeleteGroup'),('RA','Tag_EditAll'),('TagAdmin','Tag_EditAll'),('GroupAdmin','Tag_EditGroup'),('AppAdmin','Tag_EditSelf'),('RA','Tag_EditSelf'),('StandardUser','Tag_EditSelf'),('TagAdmin','Tag_EditSelf'),('GroupAdmin','Tag_ExportCSV'),('AppAdmin','Tag_ViewAll'),('RA','Tag_ViewAll'),('TagAdmin','Tag_ViewAll'),('GroupAdmin','Tag_ViewGroup'),('Guest','Tag_ViewGroup'),('RA','Tag_ViewSelf'),('StandardUser','Tag_ViewSelf'),('TagAdmin','Tag_ViewSelf'),('Typetag.ViewAll','Typetag.Admin'),('Typetag.ViewSelf','Typetag.Admin'),('Typetag.CodaAll','Typetag.Coda'),('Typetag.CodaSelf','Typetag.Coda'),('Typetag_ViewAll','Typetag.CodaAll'),('Typetag_ViewSelf','Typetag.CodaSelf'),('Typetag_EditAll','Typetag.Create'),('Typetag_EditSelf','Typetag.Create'),('Typetag_EditAll','Typetag.Delete'),('Typetag_EditAll','Typetag.Update'),('Typetag_EditSelf','Typetag.UpdateDeleteSelf'),('Typetag_ViewAll','Typetag.ViewAll'),('Typetag_ViewSelf','Typetag.ViewSelf'),('TagAdmin','Typetag_EditAll'),('AppAdmin','Typetag_EditSelf'),('StandardUser','Typetag_EditSelf'),('TagAdmin','Typetag_EditSelf'),('AppAdmin','Typetag_ViewAll'),('TagAdmin','Typetag_ViewAll'),('StandardUser','Typetag_ViewSelf'),('TagAdmin','Typetag_ViewSelf'),('User_View','User.Admin'),('User_View','User.Coda'),('User_EditAll','User.Create'),('User_EditAll','User.Delete'),('Authenticated','User.Logout.Logout'),('User_EditAll','User.Update'),('User_EditSelf','User.UpdateDeleteSelf'),('User_EditSelf','User.UpdateSelf'),('User_UpdateSelf','User.UpdateSelf'),('Administrateur','User_EditAll'),('Authenticated','User_EditSelf'),('Authenticated','User_UpdateSelf'),('Administrateur','User_View'),('User_EditAll','User_View'),('Valeurparam.ViewAll','Valeurparam.Admin'),('Valeurparam.ViewSelf','Valeurparam.Admin'),('Valeurparam.CodaAll','Valeurparam.Coda'),('Valeurparam.CodaSelf','Valeurparam.Coda'),('Valeurparam_ViewAll','Valeurparam.CodaAll'),('Valeurparam_ViewSelf','Valeurparam.CodaSelf'),('Valeurparam_EditAll','Valeurparam.Create'),('Valeurparam_EditSelf','Valeurparam.Create'),('Valeurparam_EditAll','Valeurparam.Delete'),('Valeurparam_EditAll','Valeurparam.Update'),('Valeurparam_EditSelf','Valeurparam.UpdateDeleteSelf'),('Valeurparam_ViewAll','Valeurparam.ViewAll'),('Valeurparam_ViewSelf','Valeurparam.ViewSelf'),('AppAdmin','Valeurparam_EditSelf'),('StandardUser','Valeurparam_EditSelf'),('AppAdmin','Valeurparam_ViewAll'),('StandardUser','Valeurparam_ViewSelf');
/*!40000 ALTER TABLE `AuthItemChild` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Message`
--

DROP TABLE IF EXISTS `Message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Message` (
  `id` int(11) NOT NULL,
  `_intname` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `language` varchar(16) NOT NULL DEFAULT '',
  `translation` text,
  PRIMARY KEY (`id`,`language`),
  KEY `message_fk_user_1` (`user_id`),
  CONSTRAINT `message_fk_user_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `message_ibfk_1` FOREIGN KEY (`id`) REFERENCES `SourceMessage` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Message`
--

LOCK TABLES `Message` WRITE;
/*!40000 ALTER TABLE `Message` DISABLE KEYS */;
/*!40000 ALTER TABLE `Message` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Rights`
--

DROP TABLE IF EXISTS `Rights`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Rights` (
  `itemname` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  PRIMARY KEY (`itemname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Rights`
--

LOCK TABLES `Rights` WRITE;
/*!40000 ALTER TABLE `Rights` DISABLE KEYS */;
INSERT INTO `Rights` VALUES ('Admin',2,0),('Administrateur',2,5),('AuditTrail.AuditAdmin.AuditAdmin',0,0),('Audit_View',1,0),('Authenticated',2,1),('Base_Navigation',1,3),('CascadeDelete',0,112),('Guest',2,2),('Site.Error',0,61),('Site.Index',0,60),('Site.Login',0,63),('Site.Logout',0,64),('Site.Options',0,62),('User.Admin',0,107),('User.Coda',0,106),('User.Create',0,108),('User.Default.Index',0,108),('User.Delete',0,110),('User.Login.Login',0,109),('User.Logout.Logout',0,110),('User.Recovery.Recovery',0,112),('User.Registration.Registration',0,113),('User.Update',0,109),('User.UpdateDeleteSelf',0,111),('User.UpdateSelf',0,111),('User_EditAll',1,41),('User_EditSelf',1,42),('User_UpdateSelf',1,42),('User_View',1,40),('Visiteur',2,4);
/*!40000 ALTER TABLE `Rights` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `SourceMessage`
--

DROP TABLE IF EXISTS `SourceMessage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `SourceMessage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `_intname` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `category` varchar(32) DEFAULT NULL,
  `message` text,
  PRIMARY KEY (`id`),
  KEY `sourcemessage_fk_user_1` (`user_id`),
  CONSTRAINT `sourcemessage_fk_user_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=552 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `SourceMessage`
--

LOCK TABLES `SourceMessage` WRITE;
/*!40000 ALTER TABLE `SourceMessage` DISABLE KEYS */;
INSERT INTO `SourceMessage` VALUES (1,NULL,NULL,'app','i18n Configuration'),(2,NULL,NULL,'app','Administration'),(3,NULL,NULL,'app','Internationalization'),(4,NULL,NULL,'app','Cancel'),(5,NULL,NULL,'simpleWorkflow','SWWorkflowSource initialized - basePath : application.ezworkflows'),(6,NULL,NULL,'simpleWorkflow','loading workflow {wfId} from file {file}'),(7,NULL,NULL,'RightsModule.core','You are not authorized to perform this action.'),(8,NULL,NULL,'app','Manage Poste'),(9,NULL,NULL,'app','Pas de résultats'),(10,NULL,NULL,'app','Résultats {start}-{end} sur {count} (page {page} sur {pages}).'),(11,NULL,NULL,'app','< Précédent'),(12,NULL,NULL,'app','Suivant >'),(13,NULL,NULL,'app','Aller à la page:'),(14,NULL,NULL,'app','Edition'),(15,NULL,NULL,'app','Suppression'),(16,NULL,NULL,'app','Hostname'),(17,NULL,NULL,'app','Tags'),(18,NULL,NULL,'app','Ecole'),(19,NULL,NULL,'app','Error 404'),(20,NULL,NULL,'app','Manage Ecole'),(21,NULL,NULL,'app','Nom'),(22,NULL,NULL,'app','Postes'),(23,NULL,NULL,'app','Manage Tag'),(24,NULL,NULL,'app','Manage Table'),(25,NULL,NULL,'app','Yes'),(26,NULL,NULL,'app','No'),(27,NULL,NULL,'app','Name'),(28,NULL,NULL,'app','Description'),(29,NULL,NULL,'app','Status'),(30,NULL,NULL,'app','NameFormat'),(31,NULL,NULL,'app','Is Profile'),(32,NULL,NULL,'app','Components'),(33,NULL,NULL,'app','Relations (source)'),(34,NULL,NULL,'app','Relations (destination)'),(35,NULL,NULL,'app','Update Table'),(36,NULL,NULL,'app','Update Poste'),(37,NULL,NULL,'app','Appearance options'),(38,NULL,NULL,'app','Search records'),(39,NULL,NULL,'app','Perform a new query'),(40,NULL,NULL,'app','Statistics'),(41,NULL,NULL,'app','Create Tag'),(42,NULL,NULL,'app','Tag tag1 successfully created.'),(43,NULL,NULL,'app','Poste object semtest-c-4242-201303250907 successfully updated.'),(44,NULL,NULL,'app','Poste object semtest-c-4242-201303250907.ceti.etat-ge.ch successfully updated.'),(45,NULL,NULL,'app','Update Tag'),(46,NULL,NULL,'app','Tag object PBOURQ successfully updated.'),(47,NULL,NULL,'app','Poste object semtest-c-4242 successfully updated.'),(48,NULL,NULL,'app','Tag object PEAUVI successfully updated.'),(49,NULL,NULL,'app','Poste object toto2 successfully updated.'),(50,NULL,NULL,'app','Tag tag2 successfully created.'),(51,NULL,NULL,'app','Tag tag3 successfully created.'),(52,NULL,NULL,'app','Manage Component'),(53,NULL,NULL,'app','Show_admin'),(54,NULL,NULL,'app','Show_filter'),(55,NULL,NULL,'app','Show_form'),(56,NULL,NULL,'app','Show_coda'),(57,NULL,NULL,'app','Table'),(58,NULL,NULL,'app','Comptype'),(59,NULL,NULL,'app','Parameters'),(60,NULL,NULL,'app','Create Table'),(61,NULL,NULL,'app','Create Component'),(62,NULL,NULL,'app','Value'),(63,NULL,NULL,'app','Parameter'),(64,NULL,NULL,'app','Component'),(65,NULL,NULL,'app','Nom Puppet'),(66,NULL,NULL,'app','Numéro de série'),(67,NULL,NULL,'app','Manage Relation'),(68,NULL,NULL,'app','Relname'),(69,NULL,NULL,'app','Invrelname'),(70,NULL,NULL,'app','Reldescription'),(71,NULL,NULL,'app','Invreldescription'),(72,NULL,NULL,'app','Show_invadmin'),(73,NULL,NULL,'app','Show_invfilter'),(74,NULL,NULL,'app','Show_invform'),(75,NULL,NULL,'app','Show_invcoda'),(76,NULL,NULL,'app','Source'),(77,NULL,NULL,'app','Destination'),(78,NULL,NULL,'app','Reltype'),(79,NULL,NULL,'app','Create Relation'),(80,NULL,NULL,'app','Manage TagParam'),(81,NULL,NULL,'app','Tag'),(82,NULL,NULL,'app','Create Tagparam'),(83,NULL,NULL,'app','Parametres'),(84,NULL,NULL,'app','Manage ParamValue'),(85,NULL,NULL,'app','Valeurs'),(86,NULL,NULL,'app','Update Relation'),(87,NULL,NULL,'app','Delete Table'),(88,NULL,NULL,'app','Delete component'),(89,NULL,NULL,'app','Tag HPLasertJet2430dtn successfully created.'),(90,NULL,NULL,'app','Tagparam Adresse IP successfully created.'),(91,NULL,NULL,'app','Tagparam Nom successfully created.'),(92,NULL,NULL,'app','Tagparam Defaut successfully created.'),(93,NULL,NULL,'app','Manage ValeurParam'),(94,NULL,NULL,'app','Valeur'),(95,NULL,NULL,'app','Parametre'),(96,NULL,NULL,'app','Create Valeurparam'),(97,NULL,NULL,'app','Valeurparam 192.168.1.101 successfully created.'),(98,NULL,NULL,'app','Valeurparam PEAUVILASER1 successfully created.'),(99,NULL,NULL,'app','Valeurparam 1 successfully created.'),(100,NULL,NULL,'app','Manage TypeTag'),(101,NULL,NULL,'app','Poste'),(102,NULL,NULL,'app','Type de tag'),(103,NULL,NULL,'app','Create Typetag'),(104,NULL,NULL,'app','Typetag Default tag successfully created.'),(105,NULL,NULL,'app','Typetag HPLasertJet2430dtn successfully created.'),(106,NULL,NULL,'app','Update TagParam'),(107,NULL,NULL,'app','Tagparam object Adresse IP successfully updated.'),(108,NULL,NULL,'app','Tagparam object Nom successfully updated.'),(109,NULL,NULL,'app','Tagparam object Defaut successfully updated.'),(110,NULL,NULL,'app','Tag object semtest-c-4242/HPLasertJet2430dtn successfully updated.'),(111,NULL,NULL,'app','Update ValeurParam'),(112,NULL,NULL,'app','Poste object SEMTEST/semtest-c-4242 successfully updated.'),(113,NULL,NULL,'app','Poste object SEMTEST/toto successfully updated.'),(114,NULL,NULL,'app','Poste object SEMTEST/toto2 successfully updated.'),(115,NULL,NULL,'app','Poste object SEMTEST/semtest-c-4242-201303250907.ceti.etat-ge.ch successfully updated.'),(116,NULL,NULL,'app','Create Poste'),(117,NULL,NULL,'app','Typetag SEMTEST successfully created.'),(118,NULL,NULL,'app','Automatic'),(119,NULL,NULL,'app','Update TypeTag'),(120,NULL,NULL,'app','Typetag object SEMTEST successfully updated.'),(121,NULL,NULL,'app','Typetag OpenSankore successfully created.'),(122,NULL,NULL,'app','Tagparam Résolution successfully created.'),(123,NULL,NULL,'app','Poste object SEMTEST/semtest-c-4243-201303261000.ceti.etat-ge.ch successfully updated.'),(124,NULL,NULL,'app','Tag SEMTEST/semtest-c-4243-201303261000.ceti.etat-ge.ch/HPLasertJet2430dtn successfully created.'),(125,NULL,NULL,'app','Valeurparam Adresse IP: 192.168.2.201 successfully created.'),(126,NULL,NULL,'app','Valeurparam Nom: PEAUVILASER2 successfully created.'),(127,NULL,NULL,'app','Valeurparam Defaut: 0 successfully created.'),(128,NULL,NULL,'app','Tag SEMTEST/semtest-c-4242/HPLasertJet2430dtn successfully created.'),(129,NULL,NULL,'app','Delete Tag'),(130,NULL,NULL,'app','Poste AUBEPINE/AUBE1 successfully created.'),(131,NULL,NULL,'app','Tag AUBEPINE/AUBE1/HPLasertJet2430dtn successfully created.'),(132,NULL,NULL,'app','Tag AUBEPINE/AUBE1/OpenSankore successfully created.'),(133,NULL,NULL,'app','Tag object AUBEPINE/AUBE1/OpenSankore successfully updated.'),(134,NULL,NULL,'app','Tag object AUBEPINE/AUBE1/HPLasertJet2430dtn successfully updated.'),(135,NULL,NULL,'app','Tag SEMTEST/SEMTEST-C-4343/HPLasertJet2430dtn successfully created.'),(136,NULL,NULL,'app','Invalid request. Please do not repeat this request again.'),(137,NULL,NULL,'app','Tag SEMTEST/SEMTEST-C-4343/OpenSankore successfully created.'),(138,NULL,NULL,'app','Tag AUBEPINE/AUBE1/SEMTEST successfully created.'),(139,NULL,NULL,'app','Tag SEMTEST/SEMTEST-C-4343/SEMTEST successfully created.'),(140,NULL,NULL,'app','Typetag testtag successfully created.'),(141,NULL,NULL,'app','Tag SEMTEST/SEMTEST-C-4343/testtag successfully created.'),(142,NULL,NULL,'app','Typetag object HPLaserJet2430dtn successfully updated.'),(143,NULL,NULL,'app','Tagparam object adresse_ip successfully updated.'),(144,NULL,NULL,'app','Tagparam object resolution successfully updated.'),(145,NULL,NULL,'app','Tagparam param1 successfully created.'),(146,NULL,NULL,'app','Tag SEMTEST/SEMTEST-C-4343/HPLaserJet2430dtn successfully created.'),(147,NULL,NULL,'app','Delete Poste'),(148,NULL,NULL,'app','Tag AUBEPINE/AUBE1/testtag successfully created.'),(149,NULL,NULL,'app','Tag object SEMTEST/SEMTEST-C-4343/testtag successfully updated.'),(150,NULL,NULL,'app','Search options'),(151,NULL,NULL,'app','DB management'),(152,NULL,NULL,'app','Groupement'),(153,NULL,NULL,'app','Manage Groupement'),(154,NULL,NULL,'app','Create Groupement'),(155,NULL,NULL,'app','Groupement Linux EP successfully created.'),(156,NULL,NULL,'app','Groupement Mac successfully created.'),(157,NULL,NULL,'app','Groupement Linux CO successfully created.'),(158,NULL,NULL,'app','Groupement Linux PO successfully created.'),(159,NULL,NULL,'app','Groupement Windows successfully created.'),(160,NULL,NULL,'app','Update Component'),(161,NULL,NULL,'app','Manage Fait'),(162,NULL,NULL,'app','Fact'),(163,NULL,NULL,'app','Create Fait'),(164,NULL,NULL,'app','Fait semconfigtype == EP successfully created.'),(165,NULL,NULL,'app','Faits'),(166,NULL,NULL,'app','Update Groupement'),(167,NULL,NULL,'app','Fait operatingsystem == Ubuntu successfully created.'),(168,NULL,NULL,'app','Fait operatingsystemrelease == 12.04 successfully created.'),(169,NULL,NULL,'app','Groupement Serveur successfully created.'),(170,NULL,NULL,'app','Fait lsbdistid == Debian successfully created.'),(171,NULL,NULL,'app','Fait lsbdistcodename == squeeze successfully created.'),(172,NULL,NULL,'app','Fait domain == ceti.etat-ge.ch successfully created.'),(173,NULL,NULL,'app','Fait operatingsystem == windows successfully created.'),(174,NULL,NULL,'app','Classe'),(175,NULL,NULL,'app','Typetag object OpenSankore successfully updated.'),(176,NULL,NULL,'app','Typetag object testtag successfully updated.'),(177,NULL,NULL,'app','Update Fait'),(178,NULL,NULL,'app','Fait object semconfigtype == EP2 successfully updated.'),(179,NULL,NULL,'app','Fait object semconfigtype == EP successfully updated.'),(180,NULL,NULL,'app','Manage Fait Groupement'),(181,NULL,NULL,'app','Manage TagAuto'),(182,NULL,NULL,'app','Create Tagauto'),(183,NULL,NULL,'app','Manage Fait TagAuto'),(184,NULL,NULL,'app','Tagauto TagAuto1 successfully created.'),(185,NULL,NULL,'app','Create Fait_tagauto'),(186,NULL,NULL,'app','Manage Fait_tagauto'),(187,NULL,NULL,'app','Update TagAuto'),(188,NULL,NULL,'app','Tagauto object VM successfully updated.'),(189,NULL,NULL,'app','Fait_tagauto is_virtual == true successfully created.'),(190,NULL,NULL,'app','Tagauto object VM Linux successfully updated.'),(191,NULL,NULL,'app','Fait_tagauto kernel == Linux successfully created.'),(192,NULL,NULL,'app','Tagauto TagAutoPasValide successfully created.'),(193,NULL,NULL,'app','Fait_tagauto is_virtual == false successfully created.'),(194,NULL,NULL,'app','Fait_tagauto kernelversion == 3.2.0 successfully created.'),(195,NULL,NULL,'app','Update Fait TagAuto'),(196,NULL,NULL,'app','Fait_tagauto object is_virtual == true successfully updated.'),(197,NULL,NULL,'app','Fait_tagauto kernelversion == 3.1.0 successfully created.'),(198,NULL,NULL,'app','Tags Auto'),(199,NULL,NULL,'app','Tag object SEMTEST/SEMTEST-C-4343/hplaserjet2430dtn successfully updated.'),(200,NULL,NULL,'app','Typetag HP LaserJet 3052 successfully created.'),(201,NULL,NULL,'app','Tagparam ParDefaut successfully created.'),(202,NULL,NULL,'app','Tag SEMTEST/SEMTEST-C-4343/HP LaserJet 3052 successfully created.'),(203,NULL,NULL,'app','Delete Typetag'),(204,NULL,NULL,'app','Tagparam adresse_ip successfully created.'),(205,NULL,NULL,'app','Tag object SEMTEST/SEMTEST-C-4343/HP LaserJet 3052 successfully updated.'),(206,NULL,NULL,'app','Fait_tagauto timezone == CET successfully created.'),(207,NULL,NULL,'app','Fait_tagauto object timezone == CEST successfully updated.'),(208,NULL,NULL,'app','Typetag InstallAppli successfully created.'),(209,NULL,NULL,'app','Tagparam Application successfully created.'),(210,NULL,NULL,'app','Tag SEMTEST/SEMTEST-C-4343/InstallAppli successfully created.'),(211,NULL,NULL,'EditableField.editable','Enter'),(212,NULL,NULL,'app','Update Fait Groupement'),(213,NULL,NULL,'app','Manage Fait_groupement'),(214,NULL,NULL,'app','Non-existant Groupement object.'),(215,NULL,NULL,'app','Unable to find item.'),(216,NULL,NULL,'app','Invalid request. Please do not repeat this request again. PROP!'),(217,NULL,NULL,'app','Groupement object Linux EP successfully updated.'),(218,NULL,NULL,'app','Groupement object Linux EP2 successfully updated.'),(219,NULL,NULL,'app','Create Fait_groupement'),(220,NULL,NULL,'app','Fait_groupement semconfigtype == EP successfully created.'),(221,NULL,NULL,'app','Gestion des groupements'),(222,NULL,NULL,'app','Groupement test successfully created.'),(223,NULL,NULL,'app','Groupement object test2 successfully updated.'),(224,NULL,NULL,'app','Fait_groupement toto == titi successfully created.'),(225,NULL,NULL,'app','Fait_groupement titi == tata successfully created.'),(226,NULL,NULL,'app','Fait_groupement toto == tutu successfully created.'),(227,NULL,NULL,'app','Fait_groupement tata == toto successfully created.'),(228,NULL,NULL,'app','Fait_groupement tutu == titi successfully created.'),(229,NULL,NULL,'app','Delete Groupement'),(230,NULL,NULL,'app','Gestion des écoles'),(231,NULL,NULL,'app','Précédent'),(232,NULL,NULL,'app','Groupement test42 successfully created.'),(233,NULL,NULL,'app','Ecole ECOLEDETEST successfully created.'),(234,NULL,NULL,'app','Update Ecole'),(235,NULL,NULL,'app','Poste SEMTEST/test1 successfully created.'),(236,NULL,NULL,'app','Gestion des tags manuels'),(237,NULL,NULL,'app','Ecole object SEMTEST2 successfully updated.'),(238,NULL,NULL,'app','Poste SEMTEST/test2 successfully created.'),(239,NULL,NULL,'app','Gestion des tags automatiques'),(240,NULL,NULL,'app','Tagauto object TagAutoPasValide successfully updated.'),(241,NULL,NULL,'app','Tagauto testgroupement successfully created.'),(242,NULL,NULL,'app','Tagauto TagAutoDeTest successfully created.'),(243,NULL,NULL,'app','Fait_tagauto a == b successfully created.'),(244,NULL,NULL,'app','Tagauto object TagAutoDeTest successfully updated.'),(245,NULL,NULL,'app','Gestion des utilisateurs'),(246,NULL,NULL,'app','Modification'),(247,NULL,NULL,'simpleWorkflow','unable to create to SWNode'),(248,NULL,NULL,'simpleworkflow','value {node} is not a valid status'),(249,NULL,NULL,'app','Créer un utilisateur'),(250,NULL,NULL,'app','Error 403'),(251,NULL,NULL,'app','Assignments'),(252,NULL,NULL,'RightsModule.core','Assignments'),(253,NULL,NULL,'RightsModule.core','No users found.'),(254,NULL,NULL,'RightsModule.core','Name'),(255,NULL,NULL,'RightsModule.core','Roles'),(256,NULL,NULL,'RightsModule.core','Tasks'),(257,NULL,NULL,'RightsModule.core','Operations'),(258,NULL,NULL,'RightsModule.core','Inherited'),(259,NULL,NULL,'RightsModule.core','Assign'),(260,NULL,NULL,'RightsModule.core','Revoke'),(261,NULL,NULL,'RightsModule.core','Item'),(262,NULL,NULL,'app','Permissions'),(263,NULL,NULL,'RightsModule.core','Permissions'),(264,NULL,NULL,'RightsModule.core','No authorization items found.'),(265,NULL,NULL,'RightsModule.core','Hover to see from where the permission is inherited.'),(266,NULL,NULL,'RightsModule.core','Source'),(267,NULL,NULL,'app','Operations'),(268,NULL,NULL,'RightsModule.core','No operations found.'),(269,NULL,NULL,'RightsModule.core','Description'),(270,NULL,NULL,'RightsModule.core','Business rule'),(271,NULL,NULL,'RightsModule.core','Data'),(272,NULL,NULL,'RightsModule.core','Delete'),(273,NULL,NULL,'RightsModule.core','Are you sure you want to delete this operation?'),(274,NULL,NULL,'RightsModule.core','Values within square brackets tell how many children each item has.'),(275,NULL,NULL,'app','Tasks'),(276,NULL,NULL,'RightsModule.core','No tasks found.'),(277,NULL,NULL,'RightsModule.core','Are you sure you want to delete this task?'),(278,NULL,NULL,'app','Roles'),(279,NULL,NULL,'RightsModule.core','No roles found.'),(280,NULL,NULL,'RightsModule.core','Are you sure you want to delete this role?'),(281,NULL,NULL,'app','Assignations'),(282,NULL,NULL,'RightsModule.core','Assignations'),(283,NULL,NULL,'app','Assignment management'),(284,NULL,NULL,'RightsModule.core','This user has not been assigned any items.'),(285,NULL,NULL,'RightsModule.core','Type'),(286,NULL,NULL,'RightsModule.core','Assign item'),(287,NULL,NULL,'RightsModule.core','Pas de rôles.'),(288,NULL,NULL,'RightsModule.core','Les valeurs entre crochets montrent combien d\'enfants chaque rôle possède.'),(289,NULL,NULL,'RightsModule.core','Permission :name assigned.'),(290,NULL,NULL,'RightsModule.core','Operation'),(291,NULL,NULL,'RightsModule.core','Task'),(292,NULL,NULL,'RightsModule.core','Role'),(293,NULL,NULL,'RightsModule.core','Create :type'),(294,NULL,NULL,'RightsModule.core',':name created.'),(295,NULL,NULL,'RightsModule.core','Update :name'),(296,NULL,NULL,'RightsModule.core','Permission :name revoked.'),(297,NULL,NULL,'RightsModule.core','Utilisateur'),(298,NULL,NULL,'RightsModule.core','Rôles assignés'),(299,NULL,NULL,'RightsModule.core','Tâches assignées'),(300,NULL,NULL,'RightsModule.core','Opérations assignées'),(301,NULL,NULL,'RightsModule.core','Pas d\'utilisateurs trouvés.'),(302,NULL,NULL,'RightsModule.core','Cliquer sur un utilisateur pour modifier ses assignations.'),(303,NULL,NULL,'app','Tâches'),(304,NULL,NULL,'RightsModule.core','Tâches'),(305,NULL,NULL,'RightsModule.core','Pas de tâches.'),(306,NULL,NULL,'RightsModule.core','Nom'),(307,NULL,NULL,'RightsModule.core','Règle métier'),(308,NULL,NULL,'RightsModule.core','Données'),(309,NULL,NULL,'RightsModule.core','Pas d\'opérations.'),(310,NULL,NULL,'RightsModule.core','Pas de doits trouvés.'),(311,NULL,NULL,'RightsModule.core','Assigner un droit'),(312,NULL,NULL,'RightsModule.core','Supprimer'),(313,NULL,NULL,'RightsModule.core','Parents'),(314,NULL,NULL,'RightsModule.core','This item has no parents.'),(315,NULL,NULL,'RightsModule.core','Children'),(316,NULL,NULL,'RightsModule.core','Add'),(317,NULL,NULL,'RightsModule.core','This item has no children.'),(318,NULL,NULL,'RightsModule.core','Child :name added.'),(319,NULL,NULL,'RightsModule.core','Remove'),(320,NULL,NULL,'app','Typetag test1 successfully created.'),(321,NULL,NULL,'app','Typetag object test1 successfully updated.'),(322,NULL,NULL,'app','Tagparam a successfully created.'),(323,NULL,NULL,'app','Typetag manouvelleclasse successfully created.'),(324,NULL,NULL,'app','Typetag object manouvelleclasse successfully updated.'),(325,NULL,NULL,'app','Tagparam param2 successfully created.'),(326,NULL,NULL,'app','Tag SEMTEST/SEMTEST-C-4343/manouvelleclasse successfully created.'),(327,NULL,NULL,'app','<i class=\"icon-pencil\"></i>'),(328,NULL,NULL,'app','<i class=\"icon-delete\"></i>'),(329,NULL,NULL,'app','<i class=\"icon-trash\"></i>'),(330,NULL,NULL,'app','Delete Ecole'),(331,NULL,NULL,'app','Tag object SEMTEST/SEMTEST-C-4343/InstallAppli successfully updated.'),(332,NULL,NULL,'app','Delete Tagauto'),(333,NULL,NULL,'app','Profils'),(334,NULL,NULL,'app','Manage Profil'),(335,NULL,NULL,'app','Ecoles'),(336,NULL,NULL,'app','Gestion des profils'),(337,NULL,NULL,'app','Profil {Ecole} successfully created.'),(338,NULL,NULL,'app','Update Profil'),(339,NULL,NULL,'app','Typetag mongrostag successfully created.'),(340,NULL,NULL,'app','Profil object {profileuser} successfully updated.'),(341,NULL,NULL,'app','Profil object {Profileuser Id} successfully updated.'),(342,NULL,NULL,'app','Profil {Profileuser Id} successfully created.'),(343,NULL,NULL,'app','Groupements'),(344,NULL,NULL,'app','Profil'),(345,NULL,NULL,'app','Tag SEMTEST/SEMTEST-C-4444/InstallAppli successfully created.'),(346,NULL,NULL,'app','Tag object SEMTEST/SEMTEST-C-4444/InstallAppli successfully updated.'),(347,NULL,NULL,'app','Poste AUBEPINE/AUBE-C-123456 successfully created.'),(348,NULL,NULL,'app','Tag AUBEPINE/AUBE-C-123456/HP LaserJet 3052 successfully created.'),(349,NULL,NULL,'app','Poste SEMTEST/SEMTEST-C-4545 successfully created.'),(350,NULL,NULL,'app','Poste object SEMTEST/SEMTEST-C-4545 successfully updated.'),(351,NULL,NULL,'app','Poste object SEMTEST/SEMTEST-C-4444 successfully updated.'),(352,NULL,NULL,'RightsModule.core','Child :name removed.'),(353,NULL,NULL,'app','Tag SEMTEST/SEMTEST-C-4444/HP LaserJet 3052 successfully created.'),(354,NULL,NULL,'app','Fait_tagauto toto == titi successfully created.'),(355,NULL,NULL,'app','Typetag PinAppli successfully created.'),(356,NULL,NULL,'app','Tagparam Version successfully created.'),(357,NULL,NULL,'app','Tag SEMTEST/SEMTEST-C-4444/PinAppli successfully created.'),(358,NULL,NULL,'app','Tag object SEMTEST/SEMTEST-C-4444/PinAppli successfully updated.'),(359,NULL,NULL,'app','Tagparam test successfully created.'),(360,NULL,NULL,'app','Typetag object InstallAppli successfully updated.'),(361,NULL,NULL,'app','Tagauto TagAutoEP2012 successfully created.'),(362,NULL,NULL,'app','Fait_tagauto semconfigtype == EP successfully created.'),(363,NULL,NULL,'app','Tagauto object TagAutoEP2012 successfully updated.'),(364,NULL,NULL,'app','Poste object AUBEPINE/AUBE-C-123456 successfully updated.'),(365,NULL,NULL,'app','Poste object BOUGE/AUBE-C-123456 successfully updated.'),(366,NULL,NULL,'app','Tag PSEMCR/PSEMCR-4-000001/InstallAppli successfully created.'),(367,NULL,NULL,'app','Tag object PSEMCR/PSEMCR-4-000001/InstallAppli successfully updated.'),(368,NULL,NULL,'app','Tag PSEMCR/PSEMCR-4-210352/InstallAppli successfully created.'),(369,NULL,NULL,'app','Typetag testsankore successfully created.'),(370,NULL,NULL,'app','Tag PSEMCR/PSEMCR-4-210352/testsankore successfully created.'),(371,NULL,NULL,'app','Tag PSEMCR/PSEMCR-4-000001/testsankore successfully created.'),(372,NULL,NULL,'app','Tag PSEMCR/PSEMCR-4-000003/testsankore successfully created.'),(373,NULL,NULL,'app','Tag PSEMCR/PSEMCR-4-000004/testsankore successfully created.'),(374,NULL,NULL,'app','Tag PSEMCR/PSEMCR-4-000005/testsankore successfully created.'),(375,NULL,NULL,'app','Tag PSEMCR/PSEMCR-4-000011/testsankore successfully created.'),(376,NULL,NULL,'app','Tag PSEMCR/PSEMCR-4-000006/testsankore successfully created.'),(377,NULL,NULL,'app','Tag PSEMCR/PSEMCR-4-000008/testsankore successfully created.'),(378,NULL,NULL,'app','Tag PSEMCR/PSEMCR-4-000012/testsankore successfully created.'),(379,NULL,NULL,'app','Tag PSEMCR/PSEMCR-4-000007/testsankore successfully created.'),(380,NULL,NULL,'app','Tag PSEMCR/PSEMCR-4-000009/testsankore successfully created.'),(381,NULL,NULL,'app','Tag PSEMCR/PSEMCR-4-000010/testsankore successfully created.'),(382,NULL,NULL,'app','Tag SEMTEST/SEMTEST-C-4646/testsankore successfully created.'),(383,NULL,NULL,'app','Tagauto FirefoxESR17 successfully created.'),(384,NULL,NULL,'app','Fait_tagauto ecole == SEMTEST successfully created.'),(385,NULL,NULL,'app','Fait_tagauto ecole == PSEMCR successfully created.'),(386,NULL,NULL,'app','Tagauto object FirefoxESR17 successfully updated.'),(387,NULL,NULL,'app','Fait_tagauto ecole == PGSVIL successfully created.'),(388,NULL,NULL,'app','Tag SEMTEST/SEMTEST-C-4646/InstallAppli successfully created.'),(389,NULL,NULL,'app','Fait_tagauto ecole == PCONFI successfully created.'),(390,NULL,NULL,'app','Tag SEMTEST/SEMTEST-C-4646/hplaserjet2430dtn successfully created.'),(391,NULL,NULL,'app','Tag object SEMTEST/SEMTEST-C-4646/InstallAppli successfully updated.'),(392,NULL,NULL,'app','Tag SEMTEST/SEMTEST-C-4646/HP LaserJet 3052 successfully created.'),(393,NULL,NULL,'app','Tagparam description successfully created.'),(394,NULL,NULL,'app','Tagparam localisation successfully created.'),(395,NULL,NULL,'app','Tag object SEMTEST/SEMTEST-C-4646/hplaserjet2430dtn successfully updated.'),(396,NULL,NULL,'app','Tag SEMTEST/SEMTEST-C-4646/testtag successfully created.'),(397,NULL,NULL,'app','Tag object SEMTEST/SEMTEST-C-4646/testtag successfully updated.'),(398,NULL,NULL,'app','Routeur'),(399,NULL,NULL,'app','Date_creation'),(400,NULL,NULL,'app','Date_contact'),(401,NULL,NULL,'app','Heure_creation'),(402,NULL,NULL,'app','Heure_contact'),(403,NULL,NULL,'app','Typetag SupprAppli successfully created.'),(404,NULL,NULL,'app','Tag SEMTEST/SEMTEST-C-4646/SupprAppli successfully created.'),(405,NULL,NULL,'app','Typetag Imprimante successfully created.'),(406,NULL,NULL,'app','Tagparam pilote successfully created.'),(407,NULL,NULL,'app','Tagparam ip successfully created.'),(408,NULL,NULL,'app','Tagparam location successfully created.'),(409,NULL,NULL,'app','Tagparam name successfully created.'),(410,NULL,NULL,'app','Tag SEMTEST/SEMTEST-C-4646/Imprimante successfully created.'),(411,NULL,NULL,'app','Tag object SEMTEST/SEMTEST-C-4647/Imprimante successfully updated.'),(412,NULL,NULL,'app','Tag object SEMTEST/SEMTEST-C-4646/Imprimante successfully updated.'),(413,NULL,NULL,'app','Type'),(414,NULL,NULL,'app','Delete Tagparam'),(415,NULL,NULL,'app','Typetag object Imprimante successfully updated.'),(416,NULL,NULL,'app','Possibles'),(417,NULL,NULL,'app','Tagparam testparam successfully created.'),(418,NULL,NULL,'app','Operateur'),(419,NULL,NULL,'app','Fait ecole = PSEMTEST successfully created.'),(420,NULL,NULL,'app','Selection'),(421,NULL,NULL,'app','Manage Selection'),(422,NULL,NULL,'app','Create Selection'),(423,NULL,NULL,'app','Selection {Faits} successfully created.'),(424,NULL,NULL,'app','Fait ecole = SEMTEST successfully created.'),(425,NULL,NULL,'app','Update Selection'),(426,NULL,NULL,'app','Fait is_virtual = true successfully created.'),(427,NULL,NULL,'app','Tag SEMTEST/SEMTEST-C-4647/Imprimante successfully created.'),(428,NULL,NULL,'app','Tag object {Poste}/Imprimante successfully updated.'),(429,NULL,NULL,'app','Create Profil'),(430,NULL,NULL,'app','Tag {Poste}/Imprimante successfully created.'),(431,NULL,NULL,'app','Fait_tagauto aaa == a,b,c successfully created.'),(432,NULL,NULL,'app','Fait_tagauto ecole IN AUBEPINE,SEMTEST,SEMTS successfully created.'),(433,NULL,NULL,'app','Groupement Linux EP Dev successfully created.'),(434,NULL,NULL,'app','Groupement Linux EP Valid successfully created.'),(435,NULL,NULL,'app','Groupement Linux EP Prod successfully created.'),(436,NULL,NULL,'app','Fait_groupement ecole == SEMTEST successfully created.'),(437,NULL,NULL,'app','Tag {Poste}/InstallAppli successfully created.'),(438,NULL,NULL,'app','Fait_groupement ecole == TOTO successfully created.'),(439,NULL,NULL,'app','Groupement object Linux EP Dev successfully updated.'),(440,NULL,NULL,'app','Fait_groupement ecole == AUBEPINE,SEMTEST,TOTO successfully created.'),(441,NULL,NULL,'app','Fait_groupement ecole == AUBEPINE,TOTO successfully created.'),(442,NULL,NULL,'app','Tag object {Postes}/Imprimante successfully updated.'),(443,NULL,NULL,'app','Tag Imprimante successfully created.'),(444,NULL,NULL,'app','Tag InstallAppli successfully created.'),(445,NULL,NULL,'app','Icone'),(446,NULL,NULL,'app','Typetag Firefox successfully created.'),(447,NULL,NULL,'app','Typetag object Firefox successfully updated.'),(448,NULL,NULL,'app','Typetag object SupprAppli successfully updated.'),(449,NULL,NULL,'app','Tag Firefox successfully created.'),(450,NULL,NULL,'app','Fait_tagauto ecole IN AUBEPINE,SEMTS successfully created.'),(451,NULL,NULL,'app','Tagparam homepage successfully created.'),(452,NULL,NULL,'app','Tag object Firefox successfully updated.'),(453,NULL,NULL,'app','User'),(454,NULL,NULL,'app','Users'),(455,NULL,NULL,'app','VNC'),(456,NULL,NULL,'app','Kick'),(457,NULL,NULL,'app','Error 500'),(458,NULL,NULL,'app','Tag object InstallAppli successfully updated.'),(459,NULL,NULL,'app','Groupement SEMTEST Linux successfully created.'),(460,NULL,NULL,'app','Fait_groupement operatingsystem == Linux successfully created.'),(461,NULL,NULL,'app','Fait_groupement operatingsystem == Ubuntu successfully created.'),(462,NULL,NULL,'app','Groupement object SEMTEST Linux successfully updated.'),(463,NULL,NULL,'app','Fait_groupement operatingsystemrelease == 12.04 successfully created.'),(464,NULL,NULL,'app','Valeurparam object Application: htop successfully updated.'),(465,NULL,NULL,'app','Poste SEMTEST/SEMTEST-AA-VMAA successfully created.'),(466,NULL,NULL,'app','Poste SEMTEST/grotest successfully created.'),(467,NULL,NULL,'app','Poste object SEMTEST/grotest successfully updated.'),(468,NULL,NULL,'app','Poste object SEMTEST/SEMTEST-AA-VMAA successfully updated.'),(469,NULL,NULL,'app','Poste grotest successfully created.'),(470,NULL,NULL,'app','Poste grotest2 successfully created.'),(471,NULL,NULL,'app','Poste object SEMTEST-DD-DD successfully updated.'),(472,NULL,NULL,'app','Date Creation'),(473,NULL,NULL,'app','Date Contact'),(474,NULL,NULL,'app','Poste object SEMTEST-C-4647 successfully updated.'),(475,NULL,NULL,'app','Poste object SEMTEST-AA-AA successfully updated.'),(476,NULL,NULL,'app','Poste grotest3 successfully created.'),(477,NULL,NULL,'app','Poste grotest4 successfully created.'),(478,NULL,NULL,'app','Poste object grotest4 successfully updated.'),(479,NULL,NULL,'app','Poste grotest6 successfully created.'),(480,NULL,NULL,'app','Poste SEMTEST-C-4649 successfully created.'),(481,NULL,NULL,'app','Poste SEMTEST-C-4648 successfully created.'),(482,NULL,NULL,'app','Groupement SEMTEST-SEMCR-Linux successfully created.'),(483,NULL,NULL,'app','Fait_groupement ecole == SEMTEST,SEMCR successfully created.'),(484,NULL,NULL,'app','Groupement object SEMTEST-SEMCR-Linux successfully updated.'),(485,NULL,NULL,'app','Groupement object SEMTEST-SEMCR-Linu successfully updated.'),(486,NULL,NULL,'app','Fait_groupement ecole 6 SEMTEST,SEMCR successfully created.'),(487,NULL,NULL,'app','Fait_groupement ecole IN SEMTEST,SEMCR successfully created.'),(488,NULL,NULL,'app','Poste SEMTEST-C-12345 successfully created.'),(489,NULL,NULL,'app','Poste object SEMTEST-C-3434 successfully updated.'),(490,NULL,NULL,'app','Poste object SEMTEST-C-34354 successfully updated.'),(491,NULL,NULL,'app','Generate items'),(492,NULL,NULL,'RightsModule.core','Generate items'),(493,NULL,NULL,'RightsModule.core','Application'),(494,NULL,NULL,'RightsModule.core','Modules'),(495,NULL,NULL,'RightsModule.core','No actions found.'),(496,NULL,NULL,'RightsModule.core','Select all'),(497,NULL,NULL,'RightsModule.core','Select none'),(498,NULL,NULL,'RightsModule.core','Generate'),(499,NULL,NULL,'app','Poste object SEMCOURS-AA-DD successfully updated.'),(500,NULL,NULL,'app','Fait_tagauto toto = titi successfully created.'),(501,NULL,NULL,'app','Groupement testgroupement successfully created.'),(502,NULL,NULL,'app','Fait_groupement operatingsystem = Ubuntu successfully created.'),(503,NULL,NULL,'app','Fait_groupement operatingsystemrelease = 12.04 successfully created.'),(504,NULL,NULL,'app','Fait_groupement semconfigtype = EP successfully created.'),(505,NULL,NULL,'app','Poste SEMTEST-C-4343 successfully created.'),(506,NULL,NULL,'app','Logs'),(507,NULL,NULL,'app','Visualisation des logs'),(508,NULL,NULL,'app','Visitor'),(509,NULL,NULL,'app','Typetag Ecole successfully created.'),(510,NULL,NULL,'app','Tagparam Ecole successfully created.'),(511,NULL,NULL,'app','Typetag object Ecole successfully updated.'),(512,NULL,NULL,'app','Tag Ecole successfully created.'),(513,NULL,NULL,'app','Poste SEMTEST-C-1234 successfully created.'),(514,NULL,NULL,'app','Poste SEMTEST-C-1235 successfully created.'),(515,NULL,NULL,'app','Inventaire des machines'),(516,NULL,NULL,'app','Software'),(517,NULL,NULL,'app','Version'),(518,NULL,NULL,'app','Tag SupprAppli successfully created.'),(519,NULL,NULL,'simpleWorkflow','SWWorkflowSource initialized - basePath : application.workflows'),(520,NULL,NULL,'app','Data analysis'),(521,NULL,NULL,'app','Analyse des donnees'),(522,NULL,NULL,'app','Stats PuppetDB'),(523,NULL,NULL,'app','Typetag testsuppr successfully created.'),(524,NULL,NULL,'app','Tagparam b successfully created.'),(525,NULL,NULL,'app','Tagparam c successfully created.'),(526,NULL,NULL,'app','Typetag object testsuppr successfully updated.'),(527,NULL,NULL,'app','Poste SEMTEST-C-4242 successfully created.'),(528,NULL,NULL,'app','Groupement grptest successfully created.'),(529,NULL,NULL,'app','Fait_groupement a = 1 successfully created.'),(530,NULL,NULL,'app','Groupement object grptest successfully updated.'),(531,NULL,NULL,'app','Tagauto tagautotest successfully created.'),(532,NULL,NULL,'app','Fait_tagauto a = 1 successfully created.'),(533,NULL,NULL,'app','Tagauto object tagautotest successfully updated.'),(534,NULL,NULL,'app','Typetag ttest successfully created.'),(535,NULL,NULL,'app','Tagparam p1 successfully created.'),(536,NULL,NULL,'app','Typetag object ttest successfully updated.'),(537,NULL,NULL,'app','Tag object Ecole successfully updated.'),(538,NULL,NULL,'app','Poste object SEMTEST-C-4545 successfully updated.'),(539,NULL,NULL,'app','Résultats {start}-{end} sur {count} (page {page} sur {pages})<a href=\"\"></a>.'),(540,NULL,NULL,'app','Résultats {start}-{end} sur {count} (page {page} sur {pages})<a href=\"/poste/export\"><img src=\"/images/csv-16.png\" alt=\"CSV Icon\"></a>.'),(541,NULL,NULL,'app','Resultats {start}-{end} sur {count} (page {page} sur {pages})&nbsp;<a href=\"/poste/export\"><img src=\"/images/csv-16.png\" alt=\"CSV Icon\"></a>.'),(542,NULL,NULL,'app','Resultats {start}-{end} sur {count} (page {page} sur {pages}).&nbsp;<a href=\"/poste/export\"><img src=\"/images/csv-16.png\" alt=\"CSV Icon\"></a>'),(543,NULL,NULL,'app','Résultats {start}-{end} sur {count} (page {page} sur {pages})&nbsp;<a href=\"/tag/export\"><img src=\"/images/csv-16.png\" alt=\"CSV Icon\"></a>.'),(544,NULL,NULL,'app','Résultats {start}-{end} sur {count} (page {page} sur {pages})&nbsp;<a href=\"/tagauto/export\"><img src=\"/images/csv-16.png\" alt=\"CSV Icon\"></a>.'),(545,NULL,NULL,'app','Résultats {start}-{end} sur {count} (page {page} sur {pages}).&nbsp;<a href=\"/tagauto/export\"><img src=\"/images/csv-16.png\" alt=\"CSV Icon\"></a.'),(546,NULL,NULL,'app','Resultats {start}-{end} sur {count} (page {page} sur {pages}).&nbsp;<a href=\"/tag/export\"><img src=\"/images/csv-16.png\" alt=\"CSV Icon\"></a>'),(547,NULL,NULL,'app','Resultats {start}-{end} sur {count} (page {page} sur {pages}).&nbsp;<a href=\"/inventaire/export\"><img src=\"/images/csv-16.png\" alt=\"CSV Icon\"></a>'),(548,NULL,NULL,'app','Resultats {start}-{end} sur {count} (page {page} sur {pages}).&nbsp;<a href=\"/typetag/export\"><img src=\"/images/csv-16.png\" alt=\"CSV Icon\"></a>'),(549,NULL,NULL,'app','Resultats {start}-{end} sur {count} (page {page} sur {pages}).&nbsp;<a href=\"/groupement/export\"><img src=\"/images/csv-16.png\" alt=\"CSV Icon\"></a>'),(550,NULL,NULL,'app','Groupement Grand-Saconnex successfully created.'),(551,NULL,NULL,'app','Fait_groupement ecole IN PGSPOM,PGSAPL,PGSTOU,PGSVIL,PGSALE successfully created.');
/*!40000 ALTER TABLE `SourceMessage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `audit_trail`
--

DROP TABLE IF EXISTS `audit_trail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `audit_trail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stamp` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `class` varchar(255) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `field` varchar(255) DEFAULT NULL,
  `_intname` varchar(255) DEFAULT NULL,
  `old_value` varchar(255) DEFAULT NULL,
  `new_value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_audit_trail_stamp` (`stamp`),
  KEY `idx_audit_trail_user_id` (`user_id`),
  KEY `idx_audit_trail_action` (`action`),
  KEY `idx_audit_trail_class` (`class`),
  KEY `idx_audit_trail_class_id` (`class_id`),
  KEY `idx_audit_trail_field` (`field`),
  KEY `idx_audit_trail__intname` (`_intname`),
  KEY `idx_audit_trail_old_value` (`old_value`),
  KEY `idx_audit_trail_new_value` (`new_value`)
) ENGINE=InnoDB AUTO_INCREMENT=43053 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `audit_trail`
--

LOCK TABLES `audit_trail` WRITE;
/*!40000 ALTER TABLE `audit_trail` DISABLE KEYS */;
/*!40000 ALTER TABLE `audit_trail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `config`
--

DROP TABLE IF EXISTS `config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `config` (
  `key` varchar(100) NOT NULL,
  `value` text,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `config`
--

LOCK TABLES `config` WRITE;
/*!40000 ALTER TABLE `config` DISABLE KEYS */;
INSERT INTO `config` VALUES ('appearance_favicon','s:32:\"/media/Logos/default-favicon.png\";'),('appearance_logo','s:23:\"/media/Logos/transp.png\";'),('appearance_uitheme','s:7:\"le-frog\";'),('authorizedlanguages','a:1:{i:0;s:5:\"fr_FR\";}'),('enableinlinetranslations','s:1:\"0\";'),('fixedlang','s:5:\"fr_FR\";'),('langselect','s:5:\"Fixed\";'),('searchoptions_defaultnblines','s:2:\"20\";');
/*!40000 ALTER TABLE `config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fait`
--

DROP TABLE IF EXISTS `fait`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fait` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `_intname` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `fact` int(11) DEFAULT NULL,
  `valeur` varchar(255) DEFAULT NULL,
  `operateur` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fait_fk_user_13` (`user_id`),
  CONSTRAINT `fait_fk_user_13` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fait`
--

LOCK TABLES `fait` WRITE;
/*!40000 ALTER TABLE `fait` DISABLE KEYS */;
/*!40000 ALTER TABLE `fait` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fait_groupement`
--

DROP TABLE IF EXISTS `fait_groupement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fait_groupement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `_intname` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `fact` varchar(255) DEFAULT NULL,
  `valeur` varchar(255) DEFAULT NULL,
  `groupement_id` int(11) DEFAULT NULL,
  `operateur` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fait_fk_groupement_12` (`groupement_id`),
  KEY `fait_groupement_fk_user_9` (`user_id`),
  CONSTRAINT `fait_fk_groupement_12` FOREIGN KEY (`groupement_id`) REFERENCES `groupement` (`id`),
  CONSTRAINT `fait_groupement_fk_user_9` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fait_groupement`
--

LOCK TABLES `fait_groupement` WRITE;
/*!40000 ALTER TABLE `fait_groupement` DISABLE KEYS */;
/*!40000 ALTER TABLE `fait_groupement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fait_tagauto`
--

DROP TABLE IF EXISTS `fait_tagauto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fait_tagauto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `_intname` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `fact` varchar(255) DEFAULT NULL,
  `valeur` varchar(255) DEFAULT NULL,
  `tag_id` int(11) DEFAULT NULL,
  `operateur` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fait_tagauto_fk_user_11` (`user_id`),
  KEY `fait_tagauto_fk_tagauto_13` (`tag_id`),
  CONSTRAINT `fait_tagauto_fk_tagauto_13` FOREIGN KEY (`tag_id`) REFERENCES `tagauto` (`id`),
  CONSTRAINT `fait_tagauto_fk_user_11` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fait_tagauto`
--

LOCK TABLES `fait_tagauto` WRITE;
/*!40000 ALTER TABLE `fait_tagauto` DISABLE KEYS */;
/*!40000 ALTER TABLE `fait_tagauto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groupement`
--

DROP TABLE IF EXISTS `groupement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groupement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `_intname` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `nom` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `groupement_fk_user_8` (`user_id`),
  CONSTRAINT `groupement_fk_user_8` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groupement`
--

LOCK TABLES `groupement` WRITE;
/*!40000 ALTER TABLE `groupement` DISABLE KEYS */;
/*!40000 ALTER TABLE `groupement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventaire`
--

DROP TABLE IF EXISTS `inventaire`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inventaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `_intname` varchar(255) DEFAULT NULL,
  `software` varchar(255) DEFAULT NULL,
  `version` varchar(255) DEFAULT NULL,
  `host_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `inventaire_fk_host_1` (`host_id`),
  KEY `inventaire_fk_user_1` (`user_id`),
  CONSTRAINT `inventaire_fk_user_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `inventaire_fk_host_1` FOREIGN KEY (`host_id`) REFERENCES `poste` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=475331 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventaire`
--

LOCK TABLES `inventaire` WRITE;
/*!40000 ALTER TABLE `inventaire` DISABLE KEYS */;
/*!40000 ALTER TABLE `inventaire` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `poste`
--

DROP TABLE IF EXISTS `poste`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `poste` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `_intname` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `hostname` varchar(255) DEFAULT NULL,
  `nom_puppet` varchar(255) DEFAULT NULL,
  `numero_de_serie` varchar(255) DEFAULT NULL,
  `routeur` varchar(255) DEFAULT NULL,
  `creation` datetime NOT NULL,
  `contact` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `poste_fk_user_1` (`user_id`),
  CONSTRAINT `poste_fk_user_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1843 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `poste`
--

LOCK TABLES `poste` WRITE;
/*!40000 ALTER TABLE `poste` DISABLE KEYS */;
/*!40000 ALTER TABLE `poste` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `poste_tags`
--

DROP TABLE IF EXISTS `poste_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `poste_tags` (
  `postes_id` int(11) NOT NULL DEFAULT '0',
  `tags_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`postes_id`,`tags_id`),
  KEY `poste_tags_fk_tags_20` (`tags_id`),
  CONSTRAINT `poste_tags_fk_postes_20` FOREIGN KEY (`postes_id`) REFERENCES `poste` (`id`),
  CONSTRAINT `poste_tags_fk_tags_20` FOREIGN KEY (`tags_id`) REFERENCES `tag` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `poste_tags`
--

LOCK TABLES `poste_tags` WRITE;
/*!40000 ALTER TABLE `poste_tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `poste_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profil`
--

--
-- Table structure for table `tag`
--

DROP TABLE IF EXISTS `tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `_intname` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `type_de_tag_id` int(11) DEFAULT NULL,
  `groupement_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tag_fk_user_2` (`user_id`),
  KEY `tag_fk_typetag_9` (`type_de_tag_id`),
  KEY `tag_fk_groupement_11` (`groupement_id`),
  CONSTRAINT `tag_fk_groupement_11` FOREIGN KEY (`groupement_id`) REFERENCES `groupement` (`id`),
  CONSTRAINT `tag_fk_typetag_9` FOREIGN KEY (`type_de_tag_id`) REFERENCES `typetag` (`id`),
  CONSTRAINT `tag_fk_user_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=128 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tag`
--

LOCK TABLES `tag` WRITE;
/*!40000 ALTER TABLE `tag` DISABLE KEYS */;
/*!40000 ALTER TABLE `tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tagauto`
--

DROP TABLE IF EXISTS `tagauto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tagauto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `_intname` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `classe` varchar(255) DEFAULT NULL,
  `groupement_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tagauto_fk_user_10` (`user_id`),
  KEY `tagauto_fk_groupement_14` (`groupement_id`),
  CONSTRAINT `tagauto_fk_groupement_14` FOREIGN KEY (`groupement_id`) REFERENCES `groupement` (`id`),
  CONSTRAINT `tagauto_fk_user_10` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tagauto`
--

LOCK TABLES `tagauto` WRITE;
/*!40000 ALTER TABLE `tagauto` DISABLE KEYS */;
/*!40000 ALTER TABLE `tagauto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tagparam`
--

DROP TABLE IF EXISTS `tagparam`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tagparam` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `_intname` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `type_de_tag_id` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `possibles` text,
  PRIMARY KEY (`id`),
  KEY `tagparam_fk_user_4` (`user_id`),
  KEY `tagparam_fk_typetag_10` (`type_de_tag_id`),
  CONSTRAINT `tagparam_fk_typetag_10` FOREIGN KEY (`type_de_tag_id`) REFERENCES `typetag` (`id`),
  CONSTRAINT `tagparam_fk_user_4` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tagparam`
--

LOCK TABLES `tagparam` WRITE;
/*!40000 ALTER TABLE `tagparam` DISABLE KEYS */;
/*!40000 ALTER TABLE `tagparam` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `typetag`
--

DROP TABLE IF EXISTS `typetag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `typetag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `_intname` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `classe` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `icone` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `typetag_fk_user_7` (`user_id`),
  CONSTRAINT `typetag_fk_user_7` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `typetag`
--

LOCK TABLES `typetag` WRITE;
/*!40000 ALTER TABLE `typetag` DISABLE KEYS */;
/*!40000 ALTER TABLE `typetag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `_intname` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `lang` varchar(5) NOT NULL DEFAULT 'en_US',
  `activkey` varchar(128) NOT NULL DEFAULT '',
  `createtime` int(10) NOT NULL DEFAULT '0',
  `lastvisit` int(10) NOT NULL DEFAULT '0',
  `status` varchar(50) DEFAULT '',
  `avatar` varchar(50) DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'admin','admin','5f4dcc3b5aa765d61d8327deb882cf99','admin@ezwebapp.com','en_US','9a24eff8c15a6a141ece27eb6947da0f',1261146094,1385565096,'active','/media/Avatars/default_avatar.png');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_groupements`
--

DROP TABLE IF EXISTS `user_groupements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_groupements` (
  `users_id` int(11) NOT NULL DEFAULT '0',
  `groupements_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`users_id`,`groupements_id`),
  KEY `user_groupements_fk_groupements_18` (`groupements_id`),
  CONSTRAINT `user_groupements_fk_groupements_18` FOREIGN KEY (`groupements_id`) REFERENCES `groupement` (`id`),
  CONSTRAINT `user_groupements_fk_users_18` FOREIGN KEY (`users_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_groupements`
--

LOCK TABLES `user_groupements` WRITE;
/*!40000 ALTER TABLE `user_groupements` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_groupements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `valeurparam`
--

DROP TABLE IF EXISTS `valeurparam`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `valeurparam` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `_intname` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `valeur` varchar(255) DEFAULT NULL,
  `tag_id` int(11) DEFAULT NULL,
  `parametre_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `valeurparam_fk_user_6` (`user_id`),
  KEY `valeurparam_fk_tag_6` (`tag_id`),
  KEY `valeurparam_fk_tagparam_7` (`parametre_id`),
  CONSTRAINT `valeurparam_fk_tagparam_7` FOREIGN KEY (`parametre_id`) REFERENCES `tagparam` (`id`),
  CONSTRAINT `valeurparam_fk_tag_6` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`),
  CONSTRAINT `valeurparam_fk_user_6` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=154 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `valeurparam`
--

LOCK TABLES `valeurparam` WRITE;
/*!40000 ALTER TABLE `valeurparam` DISABLE KEYS */;
/*!40000 ALTER TABLE `valeurparam` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
