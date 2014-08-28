{*
 * Main
 *
 * Main page template
 *
 * @author Christopher Han <xiphux@gmail.com>
 * @copyright Copyright (c) 2011 Christopher Han
 * @packge GitPHP
 * @subpackage Template
 *}
<!DOCTYPE html>
<html lang="{$currentprimarylocale}">
  <!-- gitphp web interface {$version}, (C) 2006-2011 Christopher Han <xiphux@gmail.com> -->
  <head>
    <title>
    {block name=title}
    {$pagetitle}
    {/block}
    </title>
    {block name=feeds}
    {/block}
    {block name=links}
    {/block}
    {if file_exists('css/gitphp.min.css')}
    <link rel="stylesheet" href="{$baseurl}/css/gitphp.min.css" type="text/css" />
    {else}
    <link rel="stylesheet" href="{$baseurl}/css/gitphp.css" type="text/css" />
    {/if}
    {if file_exists("css/$stylesheet.min.css")}
    <link rel="stylesheet" href="{$baseurl}/css/{$stylesheet}.min.css" type="text/css" />
    {else}
    <link rel="stylesheet" href="{$baseurl}/css/{$stylesheet}.css" type="text/css" />
    {/if}
    <link rel="stylesheet" href="{$baseurl}/css/ext/jquery.qtip.min.css" type="text/css" />
    {block name=css}
    {/block}
    {if $javascript}
    <script type="text/javascript">
    var require = {
    	baseUrl: '{$baseurl}/js',
	paths: {
		jquery: [
			{if $googlejs}
			'https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min',
			{/if}
			'ext/jquery-1.8.1.min'
		],
		d3: 'ext/d3.v2.min',
		qtip: 'ext/jquery.qtip.min',
		modernizr: 'ext/modernizr.custom'
	},
	config: {
		'modules/snapshotformats': {
			formats: {
				{foreach from=$snapshotformats key=format item=extension name=formats}
				"{$format}": "{$extension}"{if !$smarty.foreach.formats.last},{/if}
				{/foreach}
			}
		},
		{if $project}
		'modules/getproject': {
			project: '{$project->GetProject()}'
		},
		{/if}
		'modules/geturl': {
			baseurl: '{$baseurl}/'
		},
		'modules/resources': {
			resources: {
				Loading: "{t escape='js'}Loading…{/t}",
				LoadingBlameData: "{t escape='js'}Loading blame data…{/t}",
				Snapshot: "{t escape='js'}snapshot{/t}",
				NoMatchesFound: '{t escape=no}No matches found for "%1"{/t}'
			}
		}
	}
    };
    {block name=javascript}
      {if file_exists('js/common.min.js')}
      require.paths.common = 'common.min';
      {/if}
      require.deps = ['common'];
    {/block}
    </script>
    <script type="text/javascript" src="{$baseurl}/js/ext/require.js"></script>
    {/if}
  </head>
  <body>
    <div class="page_header">
      <a href="http://git-scm.com" title="git homepage" rel="nofollow">
        <img src="{$baseurl}/images/git-logo.png" width="72" height="27" alt="git" class="logo" />
      </a>
      {if $supportedlocales}
      <div class="lang_select">
        <form action="{$requesturl}" method="get" id="frmLangSelect">
         <div>
	{foreach from=$requestvars key=var item=val}
	{if $var != "l"}
	<input type="hidden" name="{$var}" value="{$val|escape}" />
	{/if}
	{/foreach}
	<label for="selLang">{t}language:{/t}</label>
	<select name="l" id="selLang">
	  {foreach from=$supportedlocales key=locale item=language}
	    <option {if $locale == $currentlocale}selected="selected"{/if} value="{$locale}">{if $language}{$language} ({$locale}){else}{$locale}{/if}</option>
	  {/foreach}
	</select>
	<input type="submit" value="{t}set{/t}" id="btnLangSet" />
         </div>
	</form>
      </div>
      {/if}
      {block name=header}
      <a href="{geturl}">{if $homelink}{$homelink}{else}{t}projects{/t}{/if}</a> /
      {/block}
    </div>
{block name=main}

{/block}
    <div class="page_footer">
      {block name=footer}
      {/block}
    </div>
    <div class="attr_footer">
    	<a href="http://www.gitphp.org/" target="_blank">GitPHP by Chris Han</a>
    </div>
  </body>
</html>
