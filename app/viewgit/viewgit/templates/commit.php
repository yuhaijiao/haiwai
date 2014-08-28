<h1><?php echo htmlentities_wrapper($page['message_firstline']); ?></h1>

<table class="commit" id="commit">
<tbody>
<tr>
	<td>Author</td>
	<td><?php echo format_author($page['author_name']); ?> &lt;<?php echo htmlentities_wrapper($page['author_mail']); ?>&gt;</td>
</tr>
<tr>
	<td>Author date</td>
	<td><?php echo $page['author_datetime']; ?></td>
</tr>
<tr>
	<td>Author local date</td>
	<td><?php echo $page['author_datetime_local']; ?></td>
</tr>
<tr>
	<td>Committer</td>
	<td><?php echo format_author($page['committer_name']); ?> &lt;<?php echo htmlentities_wrapper($page['committer_mail']); ?>&gt;</td>
</tr>
<tr>
	<td>Committer date</td>
	<td><?php echo $page['committer_datetime']; ?></td>
</tr>
<tr>
	<td>Committer local date</td>
	<td><?php echo $page['committer_datetime_local']; ?></td>
</tr>
<tr>
	<td>Commit</td>
	<td><?php echo $page['commit_id']; ?></td>
</tr>
<tr>
	<td>Tree</td>
	<td><a href="<?php echo makelink(array('a' => 'tree', 'p' => $page['project'], 'h' => $page['tree_id'], 'hb' => $page['commit_id'])); ?>"><?php echo $page['tree_id']; ?></a></td>
</tr>
<?php
foreach ($page['parents'] as $parent) {
	echo "<tr>\n";
	echo "\t<td>Parent</td>\n";
	echo "\t<td><a href=\"". makelink(array('a' => 'commit', 'p' => $page['project'], 'h' => $parent)) ."\">$parent</a></td>\n";
	echo "</tr>\n";
}
?>
</tbody>
</table>

<div class="commitmessage"><pre><?php echo htmlentities_wrapper($page['message_full']); ?></pre></div>

<div class="filelist">
<table id="commit_filelist">
<thead>
<tr>
	<th colspan="2">Affected files:</th>
</tr>
</thead>
<tbody>

<?php
foreach ($page['affected_files'] as $details) {
	echo "<tr><td>";
	echo "<a href=\"" . makelink(array('a' => 'viewblob', 'p' => $page['project'], 'h' => $details['hash'], 'hb' => $page['commit_id'], 'f' => $details['name'])) . "\">$details[name]</a>";
	echo "</td><td></td></tr>";
}
?>

</tbody>
</table>
</div>

