<style>
    @media only screen and (min-width: 450px) {
        #videosmodall {
            padding-top: 30px;
            width: 370px !important;
        }
    }
    @media only screen and (max-width: 450px) {
        #videosmodall {
            padding-top: 40px;
        }
    }
</style>
<div class="modal fade" id="showVideoItem" style="z-index:1000000" tabindex="-1" role="dialog" aria-labelledby="newsDetail"
    aria-hidden="true">
    <div id="videosmodall" class="modal-dialog modal-dialog-scrollable h-100" role="document">
        <livewire:video />
    </div>
</div>
