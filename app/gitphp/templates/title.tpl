{*
 * Title
 *
 * Title template
 *
 * @author Christopher Han <xiphux@gmail.com>
 * @copyright Copyright (c) 2010 Christopher Han
 * @package GitPHP
 * @subpackage Template
 *}

<div class="title">
	{if $titlecommit}
		{if $target == 'commitdiff'}
			<a href="{geturl project=$project action=commitdiff hash=$titlecommit}" class="title">{$titlecommit->GetTitle()|escape}</a>
		{elseif $target == 'tree'}
			<a href="{geturl project=$project action=tree hash=$titletree hashbase=$titlecommit}" class="title">{$titlecommit->GetTitle()|escape}</a>
		{else}
			<a href="{geturl project=$project action=commit hash=$titlecommit}" class="title">{$titlecommit->GetTitle()|escape}</a>
		{/if}
		{include file='refbadges.tpl' commit=$titlecommit}
	{else}
		{if $target == 'summary'}
			<a href="{geturl project=$project}" class="title">&nbsp;</a>
		{elseif $target == 'shortlog'}
			{if $disablelink}
			  {t}shortlog{/t}
			{else}
			  <a href="{geturl project=$project action=shortlog}" class="title">{t}shortlog{/t}</a>
			{/if}
		{elseif $target == 'tags'}
			{if $disablelink}
			  {t}tags{/t}
			{else}
			  <a href="{geturl project=$project action=tags}" class="title">{t}tags{/t}</a>
			{/if}
		{elseif $target == 'heads'}
			{if $disablelink}
			  {t}heads{/t}
			{else}
			  <a href="{geturl project=$project action=heads}" class="title">{t}heads{/t}</a>
			{/if}
		{else}
			&nbsp;
		{/if}
	{/if}
</div>
