
<?php if(CheckPermission("Expenses", "all_read,own_read")){ ?>
					<li class="<?=($this->router->class==="expenses")?"active":"not-active"?>">
						<a href="<?php echo base_url("expenses"); ?>"><i class="glyphicon glyphicon-credit-card"></i> <span>Expenses</span></a>
					</li><?php }?>
<?php if(CheckPermission("Income", "all_read,own_read")){ ?>
					<li class="<?=($this->router->class==="income")?"active":"not-active"?>">
						<a href="<?php echo base_url("income"); ?>"><i class="glyphicon glyphicon-usd"></i> <span>Income</span></a>
					</li><?php }?>
<?php if(CheckPermission("Expense Category", "all_read,own_read")){ ?>
					<li class="<?=($this->router->class==="expense_category")?"active":"not-active"?>">
						<a href="<?php echo base_url("expense_category"); ?>"><i class="glyphicon glyphicon-align-left"></i> <span>Expense Category</span></a>
					</li><?php }?>
<?php if(CheckPermission("Income Category", "all_read,own_read")){ ?>
					<li class="<?=($this->router->class==="income_category")?"active":"not-active"?>">
						<a href="<?php echo base_url("income_category"); ?>"><i class="glyphicon glyphicon-align-right"></i> <span>Income Category</span></a>
					</li><?php }?>
