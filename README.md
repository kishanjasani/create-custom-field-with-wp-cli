# Create Custom Field With Wp CLI

Wp CLI command that will create a custom field for Projects

## To use this command.

Clone this repo and install plugin in your project.

Create Post Type : `floorplan`

Create taxonomy for hierarchical FoolPlan: `home_types`

Create taxonomy for non hierarchical FoolPlan: `home_features`

Then Create metaboxes as shown in images.

Now You go, Just run below command to generate dummy post for your project.

```
wp wpc generate_florplans --amount=10
```

**--amount** : Specify the hw many number of posts you want to generate.

![Demo](https://github.com/kishanjasani/create-custom-field-with-wp-cli/blob/master/screenshot-wp-cli.local-2020.09.03-18_25_25.png)
