ALTER TABLE `Booking`.`Event_Collect` 
ADD COLUMN `TIMESTAMPREC` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `Used`;


ALTER TABLE `Booking`.`Event_Delivery` 
ADD COLUMN `TIMESTAMPREC` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `Set_Number`;


ALTER TABLE `Booking`.`Event_Usage` 
ADD COLUMN `TIMESTAMPREC` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `Qty_Refilled`;


ALTER TABLE `Booking`.`Event_Req` 
ADD COLUMN `TIMESTAMPREC` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `Driver_Ack`;


ALTER TABLE `Booking`.`Event_Patient` 
ADD COLUMN `TIMESTAMPREC` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `Order_Nr`;