<?php
    function render_calculator($conn, $calculator) { ?>

        <div class="intro">
            <h1 class="intro__heading">How MUCH DOES A LOGO COST</h1>
            <p class="intro__paragraph">Have you ever wondered how much it would cost to make a logo? This handy logo &amp; branding cost calculator is just for you.
            Find out how much your design will cost in under a minute!</p>
            <button class="intro__button save">Get started</button>
        </div>
        
        <form action="estimate.php" method="POST">
            <?php
                $query = "SELECT * FROM step WHERE calculator_id = ?";
                $stepResult = select($conn, $calculator, $query);
                while($stepRow = $stepResult->fetch_assoc()) { ?>

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
                                        <img src="<?php echo $optionRow['optionImage'] ?>" alt="<?php echo $optionRow['optionName']; ?>" class="option__image">
                                        <p><?php echo $optionRow['optionName'] ?></p>
                                    </label>
                                </div>
                                <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            <div class="input-wrapper">
                <button name="submit" class="intro__button save">Get your price estimate</button>                     
            </div>
        </form>
<?php } ?>