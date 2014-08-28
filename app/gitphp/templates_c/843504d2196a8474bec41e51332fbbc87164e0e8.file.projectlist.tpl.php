<?php /* Smarty version Smarty-3.1.11, created on 2013-04-27 06:39:37
         compiled from ".\templates\projectlist.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16211517b72a9506204-15335523%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '843504d2196a8474bec41e51332fbbc87164e0e8' => 
    array (
      0 => '.\\templates\\projectlist.tpl',
      1 => 1350007982,
      2 => 'file',
    ),
    '325c040ac3eb2e57c3cb2db39552570ef3cca8a8' => 
    array (
      0 => '.\\templates\\main.tpl',
      1 => 1350007982,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16211517b72a9506204-15335523',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'currentprimarylocale' => 0,
    'version' => 0,
    'pagetitle' => 0,
    'baseurl' => 0,
    'stylesheet' => 0,
    'javascript' => 0,
    'googlejs' => 0,
    'snapshotformats' => 0,
    'format' => 0,
    'extension' => 0,
    'project' => 0,
    'supportedlocales' => 0,
    'requesturl' => 0,
    'requestvars' => 0,
    'var' => 0,
    'val' => 0,
    'locale' => 0,
    'currentlocale' => 0,
    'language' => 0,
    'homelink' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_517b72a9a344f2_49212954',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_517b72a9a344f2_49212954')) {function content_517b72a9a344f2_49212954($_smarty_tpl) {?><?php if (!is_callable('smarty_block_t')) include 'E:\\git\\webroot\\app\\gitphp/include/smartyplugins\\block.t.php';
if (!is_callable('smarty_function_geturl')) include 'E:\\git\\webroot\\app\\gitphp/include/smartyplugins\\function.geturl.php';
if (!is_callable('smarty_function_cycle')) include 'E:\\git\\webroot\\app\\gitphp\\lib\\smarty\\libs\\plugins\\function.cycle.php';
if (!is_callable('smarty_modifier_date_format')) include 'E:\\git\\webroot\\app\\gitphp\\lib\\smarty\\libs\\plugins\\modifier.date_format.php';
if (!is_callable('smarty_function_agestring')) include 'E:\\git\\webroot\\app\\gitphp/include/smartyplugins\\function.agestring.php';
?>
<!DOCTYPE html>
<html lang="<?php echo $_smarty_tpl->tpl_vars['currentprimarylocale']->value;?>
">
  <!-- gitphp web interface <?php echo $_smarty_tpl->tpl_vars['version']->value;?>
, (C) 2006-2011 Christopher Han <xiphux@gmail.com> -->
  <head>
    <title>
    
    <?php echo $_smarty_tpl->tpl_vars['pagetitle']->value;?>

    
    </title>
    
    
    
    
    <?php if (file_exists('css/gitphp.min.css')){?>
    <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/css/gitphp.min.css" type="text/css" />
    <?php }else{ ?>
    <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/css/gitphp.css" type="text/css" />
    <?php }?>
    <?php if (file_exists("css/".((string)$_smarty_tpl->tpl_vars['stylesheet']->value).".min.css")){?>
    <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/css/<?php echo $_smarty_tpl->tpl_vars['stylesheet']->value;?>
.min.css" type="text/css" />
    <?php }else{ ?>
    <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/css/<?php echo $_smarty_tpl->tpl_vars['stylesheet']->value;?>
.css" type="text/css" />
    <?php }?>
    <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/css/ext/jquery.qtip.min.css" type="text/css" />
    
    
    <?php if ($_smarty_tpl->tpl_vars['javascript']->value){?>
    <script type="text/javascript">
    var require = {
    	baseUrl: '<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/js',
	paths: {
		jquery: [
			<?php if ($_smarty_tpl->tpl_vars['googlejs']->value){?>
			'https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min',
			<?php }?>
			'ext/jquery-1.8.1.min'
		],
		d3: 'ext/d3.v2.min',
		qtip: 'ext/jquery.qtip.min',
		modernizr: 'ext/modernizr.custom'
	},
	config: {
		'modules/snapshotformats': {
			formats: {
				<?php  $_smarty_tpl->tpl_vars['extension'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['extension']->_loop = false;
 $_smarty_tpl->tpl_vars['format'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['snapshotformats']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['extension']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['extension']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['extension']->key => $_smarty_tpl->tpl_vars['extension']->value){
$_smarty_tpl->tpl_vars['extension']->_loop = true;
 $_smarty_tpl->tpl_vars['format']->value = $_smarty_tpl->tpl_vars['extension']->key;
 $_smarty_tpl->tpl_vars['extension']->iteration++;
 $_smarty_tpl->tpl_vars['extension']->last = $_smarty_tpl->tpl_vars['extension']->iteration === $_smarty_tpl->tpl_vars['extension']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['formats']['last'] = $_smarty_tpl->tpl_vars['extension']->last;
?>
				"<?php echo $_smarty_tpl->tpl_vars['format']->value;?>
": "<?php echo $_smarty_tpl->tpl_vars['extension']->value;?>
"<?php if (!$_smarty_tpl->getVariable('smarty')->value['foreach']['formats']['last']){?>,<?php }?>
				<?php } ?>
			}
		},
		<?php if ($_smarty_tpl->tpl_vars['project']->value){?>
		'modules/getproject': {
			project: '<?php echo $_smarty_tpl->tpl_vars['project']->value->GetProject();?>
'
		},
		<?php }?>
		'modules/geturl': {
			baseurl: '<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/'
		},
		'modules/resources': {
			resources: {
				Loading: "<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array('escape'=>'js')); $_block_repeat=true; echo smarty_block_t(array('escape'=>'js'), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
Loading…<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array('escape'=>'js'), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
",
				LoadingBlameData: "<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array('escape'=>'js')); $_block_repeat=true; echo smarty_block_t(array('escape'=>'js'), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
Loading blame data…<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array('escape'=>'js'), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
",
				Snapshot: "<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array('escape'=>'js')); $_block_repeat=true; echo smarty_block_t(array('escape'=>'js'), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
snapshot<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array('escape'=>'js'), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
",
				NoMatchesFound: '<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array('escape'=>'no')); $_block_repeat=true; echo smarty_block_t(array('escape'=>'no'), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
No matches found for "%1"<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array('escape'=>'no'), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
'
			}
		}
	}
    };
    
require.deps = ['projectlist'];
<?php if (file_exists('js/projectlist.min.js')){?>
require.paths.projectlist = "projectlist.min";
<?php }?>

    </script>
    <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/js/ext/require.js"></script>
    <?php }?>
  </head>
  <body>
    <div class="page_header">
      <a href="http://git-scm.com" title="git homepage" rel="nofollow">
        <img src="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/images/git-logo.png" width="72" height="27" alt="git" class="logo" />
      </a>
      <?php if ($_smarty_tpl->tpl_vars['supportedlocales']->value){?>
      <div class="lang_select">
        <form action="<?php echo $_smarty_tpl->tpl_vars['requesturl']->value;?>
" method="get" id="frmLangSelect">
         <div>
	<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['var'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['requestvars']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value){
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['var']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
	<?php if ($_smarty_tpl->tpl_vars['var']->value!="l"){?>
	<input type="hidden" name="<?php echo $_smarty_tpl->tpl_vars['var']->value;?>
" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['val']->value, ENT_QUOTES, 'UTF-8', true);?>
" />
	<?php }?>
	<?php } ?>
	<label for="selLang"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
language:<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</label>
	<select name="l" id="selLang">
	  <?php  $_smarty_tpl->tpl_vars['language'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['language']->_loop = false;
 $_smarty_tpl->tpl_vars['locale'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['supportedlocales']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['language']->key => $_smarty_tpl->tpl_vars['language']->value){
$_smarty_tpl->tpl_vars['language']->_loop = true;
 $_smarty_tpl->tpl_vars['locale']->value = $_smarty_tpl->tpl_vars['language']->key;
?>
	    <option <?php if ($_smarty_tpl->tpl_vars['locale']->value==$_smarty_tpl->tpl_vars['currentlocale']->value){?>selected="selected"<?php }?> value="<?php echo $_smarty_tpl->tpl_vars['locale']->value;?>
"><?php if ($_smarty_tpl->tpl_vars['language']->value){?><?php echo $_smarty_tpl->tpl_vars['language']->value;?>
 (<?php echo $_smarty_tpl->tpl_vars['locale']->value;?>
)<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['locale']->value;?>
<?php }?></option>
	  <?php } ?>
	</select>
	<input type="submit" value="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
set<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
" id="btnLangSet" />
         </div>
	</form>
      </div>
      <?php }?>
      
      <a href="<?php echo smarty_function_geturl(array(),$_smarty_tpl);?>
"><?php if ($_smarty_tpl->tpl_vars['homelink']->value){?><?php echo $_smarty_tpl->tpl_vars['homelink']->value;?>
<?php }else{ ?><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
projects<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
<?php }?></a> /
      
    </div>


<div class="index_header">
<?php if (file_exists('templates/hometext.tpl')){?>
<?php echo $_smarty_tpl->getSubTemplate ('hometext.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }else{ ?>

<p>
git source code archive
</p>
<?php }?>
</div>

<div class="projectSearch">
<form method="get" action="<?php echo smarty_function_geturl(array(),$_smarty_tpl);?>
" id="projectSearchForm" enctype="application/x-www-form-urlencoded">
<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
Search projects<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
: <input type="search" name="s" class="projectSearchBox" <?php if ($_smarty_tpl->tpl_vars['search']->value){?>value="<?php echo $_smarty_tpl->tpl_vars['search']->value;?>
"<?php }?> /> <a href="<?php echo smarty_function_geturl(array(),$_smarty_tpl);?>
" class="clearSearch" <?php if (!$_smarty_tpl->tpl_vars['search']->value){?>style="display: none;"<?php }?>>X</a> <?php if ($_smarty_tpl->tpl_vars['javascript']->value){?><img src="images/search-loader.gif" class="searchSpinner" style="display: none;" alt="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
Loading…<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
" /><?php }?>
</form>
</div>

<table class="projectList">
  <?php  $_smarty_tpl->tpl_vars['proj'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['proj']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['projectlist']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['proj']->index=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['proj']->key => $_smarty_tpl->tpl_vars['proj']->value){
$_smarty_tpl->tpl_vars['proj']->_loop = true;
 $_smarty_tpl->tpl_vars['proj']->index++;
 $_smarty_tpl->tpl_vars['proj']->first = $_smarty_tpl->tpl_vars['proj']->index === 0;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['projects']['first'] = $_smarty_tpl->tpl_vars['proj']->first;
?>
    <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['projects']['first']){?>
      
      <tr class="projectHeader">
        <?php if ($_smarty_tpl->tpl_vars['sort']->value=="project"){?>
          <th><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
Project<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</th>
        <?php }else{ ?>
          <th><a class="header" href="<?php echo smarty_function_geturl(array('sort'=>'project'),$_smarty_tpl);?>
"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
Project<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</a></th>
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['sort']->value=="descr"){?>
          <th><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
Description<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</th>
        <?php }else{ ?>
          <th><a class="header" href="<?php echo smarty_function_geturl(array('sort'=>'descr'),$_smarty_tpl);?>
"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
Description<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</a></th>
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['sort']->value=="owner"){?>
          <th><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
Owner<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</th>
        <?php }else{ ?>
          <th><a class="header" href="<?php echo smarty_function_geturl(array('sort'=>'owner'),$_smarty_tpl);?>
"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
Owner<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</a></th>
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['sort']->value=="age"){?>
          <th><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
Last Change<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</th>
        <?php }else{ ?>
          <th><a class="header" href="<?php echo smarty_function_geturl(array('sort'=>'age'),$_smarty_tpl);?>
"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
Last Change<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</a></th>
        <?php }?>
        <th><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
Actions<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</th>
      </tr>
    <?php }?>

    <?php if ($_smarty_tpl->tpl_vars['currentcategory']->value!=$_smarty_tpl->tpl_vars['proj']->value->GetCategory()){?>
      <?php $_smarty_tpl->tpl_vars['currentcategory'] = new Smarty_variable($_smarty_tpl->tpl_vars['proj']->value->GetCategory(), null, 0);?>
      <?php if ($_smarty_tpl->tpl_vars['currentcategory']->value!=''){?>
        <tr class="light categoryRow">
          <th class="categoryName"><?php echo $_smarty_tpl->tpl_vars['currentcategory']->value;?>
</th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
        </tr>
      <?php }?>
    <?php }?>

    <tr class="<?php echo smarty_function_cycle(array('values'=>"light,dark"),$_smarty_tpl);?>
 projectRow">
      <td class="projectName">
        <a href="<?php echo smarty_function_geturl(array('project'=>$_smarty_tpl->tpl_vars['proj']->value),$_smarty_tpl);?>
" class="list <?php if ($_smarty_tpl->tpl_vars['currentcategory']->value!=''){?>indent<?php }?>"><?php echo $_smarty_tpl->tpl_vars['proj']->value->GetProject();?>
</a>
      </td>
      <td class="projectDescription"><a href="<?php echo smarty_function_geturl(array('project'=>$_smarty_tpl->tpl_vars['proj']->value),$_smarty_tpl);?>
" class="list"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['proj']->value->GetDescription(), ENT_QUOTES, 'UTF-8', true);?>
</a></td>
      <td class="projectOwner"><em><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['proj']->value->GetOwner(), ENT_QUOTES, 'UTF-8', true);?>
</em></td>
      <?php $_smarty_tpl->tpl_vars['projecthead'] = new Smarty_variable($_smarty_tpl->tpl_vars['proj']->value->GetHeadCommit(), null, 0);?>
      <td class="projectAge">
        <?php if ($_smarty_tpl->tpl_vars['projecthead']->value){?>
          <?php if ($_smarty_tpl->tpl_vars['proj']->value->GetAge()<7200){?>   
            <span class="agehighlight"><strong><em><time datetime="<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['proj']->value->GetEpoch(),"%Y-%m-%dT%H:%M:%S+00:00");?>
"><?php echo smarty_function_agestring(array('age'=>$_smarty_tpl->tpl_vars['proj']->value->GetAge()),$_smarty_tpl);?>
</time></em></strong></span>
          <?php }elseif($_smarty_tpl->tpl_vars['proj']->value->GetAge()<172800){?>   
            <span class="agehighlight"><em><time datetime="<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['proj']->value->GetEpoch(),"%Y-%m-%dT%H:%M:%S+00:00");?>
"><?php echo smarty_function_agestring(array('age'=>$_smarty_tpl->tpl_vars['proj']->value->GetAge()),$_smarty_tpl);?>
</time></em></span>
          <?php }else{ ?>
            <em><time datetime="<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['proj']->value->GetEpoch(),"%Y-%m-%dT%H:%M:%S+00:00");?>
"><?php echo smarty_function_agestring(array('age'=>$_smarty_tpl->tpl_vars['proj']->value->GetAge()),$_smarty_tpl);?>
</time></em>
          <?php }?>
	<?php }else{ ?>
	  <em class="empty"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
No commits<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</em>
	<?php }?>
      </td>
      <td class="link">
        <a href="<?php echo smarty_function_geturl(array('project'=>$_smarty_tpl->tpl_vars['proj']->value),$_smarty_tpl);?>
"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
summary<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</a>
	<?php if ($_smarty_tpl->tpl_vars['projecthead']->value){?>
	| 
	<a href="<?php echo smarty_function_geturl(array('project'=>$_smarty_tpl->tpl_vars['proj']->value,'action'=>'shortlog'),$_smarty_tpl);?>
"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
shortlog<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</a> | 
	<a href="<?php echo smarty_function_geturl(array('project'=>$_smarty_tpl->tpl_vars['proj']->value,'action'=>'log'),$_smarty_tpl);?>
"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
log<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</a> | 
	<a href="<?php echo smarty_function_geturl(array('project'=>$_smarty_tpl->tpl_vars['proj']->value,'action'=>'tree'),$_smarty_tpl);?>
"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
tree<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</a> | 
	<a href="<?php echo smarty_function_geturl(array('project'=>$_smarty_tpl->tpl_vars['proj']->value,'action'=>'snapshot','hash'=>'HEAD'),$_smarty_tpl);?>
" class="snapshotTip"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
snapshot<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</a>
	<?php }?>
      </td>
    </tr>
  <?php }
if (!$_smarty_tpl->tpl_vars['proj']->_loop) {
?>
    <?php if ($_smarty_tpl->tpl_vars['search']->value){?>
    <div class="message"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array(1=>$_smarty_tpl->tpl_vars['search']->value)); $_block_repeat=true; echo smarty_block_t(array(1=>$_smarty_tpl->tpl_vars['search']->value), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
No matches found for "%1"<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(1=>$_smarty_tpl->tpl_vars['search']->value), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</div>
    <?php }else{ ?>
    <div class="message"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
No projects found<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</div>
    <?php }?>
  <?php } ?>

</table>


    <div class="page_footer">
      
  <a href="<?php echo smarty_function_geturl(array('action'=>'opml'),$_smarty_tpl);?>
" class="rss_logo"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
OPML<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</a>
  <a href="<?php echo smarty_function_geturl(array('action'=>'projectindex'),$_smarty_tpl);?>
" class="rss_logo"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
TXT<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</a>

    </div>
    <div class="attr_footer">
    	<a href="http://www.gitphp.org/" target="_blank">GitPHP by Chris Han</a>
    </div>
  </body>
</html>
<?php }} ?>