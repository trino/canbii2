<div id="precision1" style="cursor: pointer;" ></div>
<div id="precision-hint1" class="input hint"></div>
<script>
$(function(){
    $('#precision1').raty({
      cancel     : true,
      cancelOff  : 'cancel-off.png',
      cancelOn   : 'cancel-on.png',
      path       : '<?php echo $this->webroot;?>raty/images',
      starHalf   : 'star-half.png',
      starOff    : 'star-off.png',
      starOn     : 'star-on.png',
      target     : '#precision-hint1',
      targetKeep : true,
      precision  : true,
      click      : function(score,evt){
                     $.ajax({
                        'url':"<?php echo $this->webroot."review/rating/".$strain_id."/".$eff_id."/".$table;?>",
                        'data':"submit=ok&rate="+score.toFixed(2),
                        'type':"post",
                        'success':function(msg){
                            alert(msg);
                        }
                     });
                    }
    });
    
    
});

</script>