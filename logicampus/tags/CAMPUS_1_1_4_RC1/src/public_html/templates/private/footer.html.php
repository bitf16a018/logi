


				</td>
			</tr>
			</table>
			
			&nbsp;<Br>
			
			</td>
			
	</tr>
</table>

<? if ($t['_newPrivMsgs']) {  ?>
<script>
	if ( confirm('You have new private messages. click "OK" to read them.') ) {
		document.location.href = '<?=appurl('pm');?>';
	}
</script>
<? } ?>

</BODY>
</HTML> 
