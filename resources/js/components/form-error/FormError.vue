<template>   
	<div class="help-block invalid-feedback">
		<p v-if="errors">{{errors[0]}}</p>		
	</div>    
</template>

<script>
    export default {
        props:['errors'],
    }
</script>
