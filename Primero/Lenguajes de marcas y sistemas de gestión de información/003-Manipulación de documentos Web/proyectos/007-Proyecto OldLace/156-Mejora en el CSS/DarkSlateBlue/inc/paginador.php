<style>
	#paginador button{
		background:none;
		border:none;
		font-size:24px;
	}
</style>
<div id="paginador">
	<a href="?tabla=<?php echo $_GET['tabla']?>&pagina=0">
		<button>🔙</button>
	</a>
	<a href="?tabla=<?php echo $_GET['tabla']?>&pagina=anterior">
		<button>⬅️</button>
	</a>
	<a href="?tabla=<?php echo $_GET['tabla']?>&pagina=siguiente">
		<button>➡️</button>
	</a>
</div>
