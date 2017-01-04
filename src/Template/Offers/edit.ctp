<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?=
            $this->Form->postLink(
                    __('Delete'), ['action' => 'delete', $offer->id], ['confirm' => __('Are you sure you want to delete # {0}?', $offer->id)]
            )
            ?></li>
        <li><?= $this->Html->link(__('List Offers'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="offers form large-9 medium-8 columns content">
    <?= $this->Form->create($offer, ['type' => 'file']) ?>
    <fieldset>
        <legend><?= __('Edit Offer') ?></legend>
        <?php
        echo $this->Form->input('title');
        echo $this->Form->input('subcategory_id', ['options' => $subcategories, 'label' => 'Category']);
        echo $this->Form->input('subtitle');
        echo $this->Form->input('photo', ['type' => 'file']);
        //  echo $this->Form->input('dir');
        echo $this->Form->input('description');
        echo $this->Form->input('email');
        echo $this->Form->input('phone');
        echo $this->Form->input('facetime_phone');
        //echo $this->Form->input('urls');
        //  echo $this->Form->input('is_expired');
        ?>
        <div class="input text field_wrapper">
            <label for="url">URL </label>

            <?php
            if (!empty($offer->urls)):
                $url = unserialize($offer->urls);
                foreach ($url as $u):
                    ?>
                    <div>
                        <input type="url" name="url[]" value="<?= $u ?>" readonly="true"/>
                        <a class="remove_button" href="javascript:void(0);" title="Remove url">Remove</a></div>
                <?php endforeach;
            endif;
            ?>                
            <div>
                <input type="url" name="url[]" value=""/>
                <a href="javascript:void(0);" class="add_button" title="Add field">Add More Urls</a>
            </div>
        </div>
    </fieldset>
<?= $this->Form->button(__('Submit')) ?>
<?= $this->Form->end() ?>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        var maxField = 10; //Input fields increment limitation
        var addButton = $('.add_button'); //Add button selector
        var wrapper = $('.field_wrapper'); //Input field wrapper
        var fieldHTML = '<div><input type="url" name="url[]" value=""/><a href="javascript:void(0);" class="remove_button" title="Remove url">Remove</a></div>'; //New input field html 
        var x = 1; //Initial field counter is 1
        $(addButton).click(function () { //Once add button is clicked
            if (x < maxField) { //Check maximum number of input fields
                x++; //Increment field counter
                $(wrapper).append(fieldHTML); // Add field html
            }
        });
        $(wrapper).on('click', '.remove_button', function (e) { //Once remove button is clicked
            e.preventDefault();
            $(this).parent('div').remove(); //Remove field html
            x--; //Decrement field counter
        });
    });
</script>