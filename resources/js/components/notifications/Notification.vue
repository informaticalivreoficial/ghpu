<template>
    <div>
        <a href="#" class="dropdown-item">                
            <div class="media">
                <img src="" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                <div class="media-body">
                    <h3 class="dropdown-item-title">
                    {{notification}}
                    </h3>
                    <p class="text-sm">Call me whenever you can...</p>
                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                </div>
            </div>                
        </a>
    </div>
</template>

<script>
export default {
    props:['notification']
}
</script>