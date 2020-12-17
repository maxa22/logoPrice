<?php
    function render_calculator($conn, $calculator) { ?>

        <div class="intro">
            <h1 class="intro__heading">How MUCH DOES A LOGO COST</h1>
            <p class="intro__paragraph">Have you ever wondered how much it would cost to make a logo? This handy logo &amp; branding cost calculator is just for you.
            Find out how much your design will cost in under a minute!</p>
            <button class="intro__button">Get started</button>
        </div>
        
            <?php
                $query = "SELECT * FROM step WHERE calculator_id = ?";
                $stepResult = select($conn, $calculator, $query);
                if($stepResult->num_rows > 0) { ?>
                <form action="<?php base(); ?>estimate" method="POST">
                <?php while($stepRow = $stepResult->fetch_assoc()) { ?>

                    <div class="input-wrapper step-<?php echo $stepRow['id']; ?>">
                        <h2><?php echo $stepRow['stepName']; ?></h2>
                        <div class="input-wrapper__options">
                            <?php  
                                $query = "SELECT * FROM options WHERE step_id = ?";
                                $optionResult = select($conn, $stepRow['id'], $query);
                                while($optionRow = $optionResult->fetch_assoc()) { ?>

                                <div>
                                    <input type="radio" name="<?php echo $stepRow['id'] . '-answer'; ?>" id="<?php echo $optionRow['optionName']  . '-' . $stepRow['id']; ?> " value="<?php echo $stepRow['id'] . '-answer-' . $optionRow['id']; ?> ">
                                    <label for="<?php echo $optionRow['optionName'] . '-' . $stepRow['id']; ?> " class="option__label">
                                        <span class="option__image-container">
                                            <?php if($optionRow['optionImage']) { ?>
                                                <img src="<?php base(); ?>images/<?php echo $optionRow['optionImage'] ?>" alt="<?php echo $optionRow['optionName']; ?>" class="option__image">
                                            <?php } ?>
                                    </span>
                                        <h3><?php echo $optionRow['optionName'] ?></h3>
                                    </label>
                                </div>
                                <?php } ?>
                        </div>
                    </div>
                <?php } ?>
                <div class="input-wrapper">
                    <button name="submit" class="intro__button">Get your price estimate</button>                     
                </div>
                </form>
                
            <?php } else { ?>
                <div class="input-wrapper">
                    <p>No default calculator or no questions added to current calculator...</p>
                </div>

<?php } return false; } ?>