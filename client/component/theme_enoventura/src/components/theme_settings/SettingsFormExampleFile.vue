<!--
  This file is part of Totara Enterprise Extensions.

  Copyright (C) 2021 onwards Totara Learning Solutions LTD

  Totara Enterprise Extensions is provided only to Totara
  Learning Solutions LTD's customers and partners, pursuant to
  the terms and conditions of a separate agreement with Totara
  Learning Solutions LTD or its affiliate.

  If you do not have an agreement with Totara Learning Solutions
  LTD, you may not access, use, modify, or distribute this software.
  Please contact [licensing@totaralearning.com] for more information.

  @author Johannes Cilliers <johannes.cilliers@totaralearning.com>
  @package theme_example
-->

<!--
This tab is similar to the Brand tab in that it shows theme files retrieved from the server.
The intention of this tab is to show how we can create additional theme files and how we can
use them on a tab. This example refers to the example theme file that we created in this
example theme's server directory (theme\example\classes\theme\file\example_file).
-->
<template>
  <Uniform
    v-if="initialValuesSet"
    :initial-values="initialValues"
    :errors="errorsForm"
    :validate="validate"
    @change="handleChange"
    @submit="submit"
  >

    <FormRowStack spacing="large">
      <FormRow
        :label="$str('formexamplefiles_label_examplefile', 'theme_enoventura')"
        :is-stacked="true"
      >
        <ImageUploadSetting
          :key="key"
          :metadata="fileData.example_image"
          :aria-label-extension="
            $str(
              'example_image',
              'theme_enoventura',
              $str('formexamplefiles_label_examplefile', 'theme_enoventura')
            )
          "
          :aria-describedby="$id('formexamplefiles-examplefile-details')"
          :context-id="contextId"
          :show-delete="showDelete(fileData.example_image)"
          @update="saveImage"
          @delete="resetImage"
        />
        <FormRowDetails :id="$id('formexamplefiles-examplefile-details')">
          {{ $str('formexamplefiles_details_examplefile', 'theme_enoventura') }}
        </FormRowDetails>
      </FormRow>

      <FormRow>
        <ButtonGroup>
          <Button
            :styleclass="{ primary: 'true' }"
            :text="$str('save', 'totara_core')"
            :aria-label="
              $str(
                'saveextended',
                'totara_core',
                $str('tab_example_file', 'theme_enoventura') +
                  ' ' +
                  $str('settings', 'totara_core')
              )
            "
            :disabled="isSaving"
            type="submit"
          />
        </ButtonGroup>
      </FormRow>
    </FormRowStack>
  </Uniform>
</template>

<script>
import theme_settings from 'tui/lib/theme_settings';
import {
  Uniform,
  FormRow,
} from 'tui/components/uniform';
import ImageUploadSetting from 'tui/components/theme_settings/ImageUploadSetting';
import FormRowDetails from 'tui/components/form/FormRowDetails';
import FormRowStack from 'tui/components/form/FormRowStack';
import Button from 'tui/components/buttons/Button';
import ButtonGroup from 'tui/components/buttons/ButtonGroup';

// Mixins
import FileMixin from 'tui/mixins/settings_form_file_mixin';

export default {
  components: {
    Uniform,
    FormRow,
    FormRowDetails,
    ImageUploadSetting,
    FormRowStack,
    Button,
    ButtonGroup,
  },

  mixins: [FileMixin],

  props: {
    /**
     * Array of Objects, each describing the properties for fields that are part
     * of this Form. There is only an Object present in this Array if it came
     * from the server as it was previously saved
     */
    savedFormFieldData: {
      type: Array,
      default: function() {
        return [];
      },
    },
    /**
     * Object with keys present for each 'Flavour' of Totara possible on the
     * site, each key value is a Boolean representing whether that Flavour is
     * currently enabled. We use this to determine whether to show various
     * settings related to a given Flavour
     */
    flavoursData: {
      type: Object,
      default: function() {
        return {};
      },
    },
    /**
     * Saving state, controlled by parent component GraphQl mutation handling
     */
    isSaving: {
      type: Boolean,
      default: function() {
        return false;
      },
    },
    /**
     * Context ID.
     */
    contextId: [Number, String],

    /**
     * Tenant ID or null if global/multi-tenancy not enabled.
     */
    selectedTenantId: Number,

    /**
     *  Customizable tenant settings
     */
    customizableTenantSettings: {
      type: [Array, String],
      required: false,
    },
  },

  data() {
    return {
      initialValues: {},
      fileData: {
        example_image: null,
      },
      initialValuesSet: false,
      errorsForm: null,
      valuesForm: null,
      resultForm: null,
      theme_settings: theme_settings,
    };
  },

  /**
   * Prepare data for consumption within Uniform
   **/
  mounted() {
    // Set the data for this Form based on (in order):
    // - use previously saved Form data from GraphQL query
    // - missing field data then supplied by Theme JSON mapping data
    // - then locally held state until (takes precedence until page is reloaded)
    let mergedFormData = this.theme_settings.mergeFormData(this.initialValues, [
      this.savedFormFieldData,
      this.valuesForm || [],
    ]);
    this.initialValues = this.theme_settings.getResolvedInitialValues(
      mergedFormData
    );
    this.initialValuesSet = true;
    this.$emit('mounted', { category: 'example_file', values: this.initialValues });
  },

  methods: {
    validate() {
      const errors = {};
      return errors;
    },

    handleChange(values) {
      this.valuesForm = values;
      if (this.errorsForm) {
        this.errorsForm = null;
      }
    },

    /**
     * Handle submission of an embedded form.
     *
     * @param {Object} currentValues The submitted form data.
     */
    submit(currentValues) {
      if (this.errorsForm) {
        this.errorsForm = null;
      }
      this.resultForm = currentValues;

      let dataToMutate = this.formatDataForMutation(currentValues);
      this.$emit('submit', dataToMutate);
    },

    /**
     * Takes Form field data and formats it to meet GraphQL mutation expectations
     *
     * @param {Object} currentValues The submitted form data.
     * @return {Object}
     **/
    formatDataForMutation(currentValues) {
      let data = {
        form: 'example_file',
        fields: [],
        files: [],
      };

      // handle non-image upload form fields
      Object.keys(currentValues).forEach(field => {
        data.fields.push({
          name: field,
          type: currentValues[field].type,
          value: String(currentValues[field].value),
        });
      });

      // image upload form field data formatting as it is handled
      // differently to other form fields in our GraphQL mutation
      Object.keys(this.fileData).forEach(file => {
        if (this.fileData[file]) {
          data.files.push(this.fileData[file]);
        }
      });

      return data;
    },
  },
};
</script>

<lang-strings>
{
"theme_enoventura": [
"example_image",
"formexamplefiles_details_examplefile",
"formexamplefiles_label_examplefile",
"tab_example_file"
],
"totara_core": [
"save",
"saveextended",
"settings",
"enabled"
]
}
</lang-strings>