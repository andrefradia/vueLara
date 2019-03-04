<template>   
	<div class="help-block invalid-feedback">
		{{errors[0]}}
	</div>    
</template>

<script>
    export default {
        props:['errors'],
    }
</script>
