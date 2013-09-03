#!/usr/bin/env ruby

# change to script
Dir.chdir File.expand_path(File.dirname(__FILE__))
# run compass compiler
Kernel.exec('compass compile -c scss/+config-minified.rb --force')
